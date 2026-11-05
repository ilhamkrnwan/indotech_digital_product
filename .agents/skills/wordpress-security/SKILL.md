---
name: wordpress-security
description: "Hardening and security engineering for WordPress sites and payment gateways: covers file protection, user enumeration defense, XML-RPC elimination, header injection, payment tampering prevention, and safe coding standards."
allowed-tools: Read Write Edit Glob Grep
---

# WordPress Security Hardening & Payment Gateway Protection

> Guidelines, security rules, and architectural standards for securing WordPress digital commerce installations and payment integrations (Midtrans, Snap, Webhooks).

---

## 1. Core Security Layers

Every WordPress deployment handling digital commerce must implement defense-in-depth across 4 layers:

```
[ L1: Web Server / HTTP ] -> Headers, .htaccess, No-PHP Execution in Uploads, No Indexes
       ↓
[ L2: Application / WP ]  -> XML-RPC Disabled, No User Enumeration, Generic Login Errors, DISALLOW_FILE_EDIT
       ↓
[ L3: Payment Gateway ]   -> Cryptographic Signature Checks, Amount Tampering Validation, State Protection
       ↓
[ L4: Data & Code Layer ] -> Nonce Verification, Strict Sanitization, Prepared SQL, esc_* Output Escaping
```

---

## 2. Payment Gateway & Webhook Security Standards

### A. Secret Key & Signature Integrity
- **Mandatory Non-Empty Key Check**: Never calculate or verify a signature if the server secret key is empty or null. A missing key must immediately cause `verify_signature()` to return `false`.
- **Timing-Safe Comparison**: Always use `hash_equals()` instead of `==` or `===` when comparing cryptographic signatures (e.g., SHA-512 in Midtrans) to prevent timing side-channel attacks.

### B. Gross Amount & Price Tampering Validation
- **Server-Side Pricing**: Never trust the price or gross amount sent from the client browser.
- **Webhook Reconciliation**: Upon receiving a webhook or callback notification, verify that `(int) round($received_gross_amount) === (int) $order_stored_amount`. If the nominal does not match, reject with HTTP 400.

### C. State Machine & Idempotency
- **Never Downgrade Settled Orders**: Once an order has transitioned to `success` or `settlement`, never allow subsequent duplicate, delayed, or forged notifications to revert the status back to `pending` or `failed`.
- **Log Payloads Securely**: Store notification payloads in order meta, but sanitize any sensitive card/payment tokens.

### D. Checkout Rate Limiting
- Use WordPress Transients or Redis/Memcached to throttle order creation by client IP (e.g., max 10 requests per 5 minutes per IP) to mitigate automated bot flooding and card testing.

---

## 3. WordPress Application Hardening

### A. Eliminate XML-RPC
XML-RPC (`xmlrpc.php`) exposes `system.multicall` which allows attackers to test hundreds of password combinations in a single HTTP request.
- Disable via filter: `add_filter( 'xmlrpc_enabled', '__return_false' );`
- Block at server level via `.htaccess` / Nginx.

### B. Block Username & Author Enumeration
- **Frontend Query**: Block `/?author=X` redirect scans which expose user login slugs.
- **REST API User Endpoint**: Unset or restrict `/wp-json/wp/v2/users` for unauthenticated requests (`! is_user_logged_in()`).

### C. Disable Built-in File Editor
Set `define( 'DISALLOW_FILE_EDIT', true );` in `wp-config.php`. This stops attackers from using compromised administrator accounts to inject PHP backdoors through the WordPress theme/plugin editor.

### D. Mask Login Errors
Override `login_errors` filter to return a generic message ("Kredensial login tidak cocok"). Never disclose whether the username or password specifically was incorrect.

---

## 4. Server & File System Defense

### A. Uploads Directory (`wp-content/uploads`)
Place a `.htaccess` file inside `wp-content/uploads/` that disables execution of any scripting files (`.php`, `.phtml`, `.sh`, `.cgi`, `.py`). Even if an arbitrary file upload occurs, the file cannot be executed as a web shell.

### B. Sensitive Files Protection
Deny public web access to:
- `wp-config.php`
- `.htaccess`
- `.env`
- `.git/`
- `readme.html` & `license.txt` (which disclose exact WordPress versions)

### C. Essential Security Headers
Send these headers on every response:
- `X-Content-Type-Options: nosniff`
- `X-Frame-Options: SAMEORIGIN`
- `X-XSS-Protection: 1; mode=block`
- `Referrer-Policy: strict-origin-when-cross-origin`
- `Permissions-Policy: camera=(), microphone=(), geolocation=()`

---

## 5. Development Checklist for New Code

1. **Input**: Every `$_POST` or `$_GET` variable must be sanitized with `sanitize_text_field()`, `sanitize_email()`, `absint()`, or `wp_unslash()`.
2. **Nonce**: Every state-changing form or AJAX request must verify a nonce with `check_ajax_referer()` or `wp_verify_nonce()`.
3. **Capabilities**: Check user permissions using `current_user_can()` before executing administrative actions.
4. **Output**: Every echo must be escaped using `esc_html()`, `esc_attr()`, `esc_url()`, or `wp_kses_post()`.
5. **SQL**: Never interpolate variables directly into SQL queries; always use `$wpdb->prepare()`.

