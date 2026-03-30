# Complete API Documentation

This document describes all API endpoints for the frontend, including required request bodies, JSON structures, and validation rules.

## General Requirements

All requests (except public endpoints) require:

```http
Accept: application/json
Authorization: Bearer {your_sanctum_token}
```

---

## 1. Authentication & Users

### 1.1 `POST /api/register`

Create a new user.

- **Body (`application/json`)**

```json
{
    "name": "John Doe",
    "email": "user@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "seeker_policy": true
}
```

- **Validations**:
    - `name`: Required, String, Max: 255.
    - `email`: Required, Valid Email, Unique in `users` table.
    - `password`: Required, Min: 6, Confirmed (must match `password_confirmation`).
    - `seeker_policy`: Required, Must be accepted (true).

### 1.2 `POST /api/login`

Authenticate a user.

- **Body (`application/json`)**

```json
{
    "email": "user@example.com",
    "password": "password123"
}
```

- **Validations**: `email` (Required, Email), `password` (Required, Min: 8).

### 1.3 `POST /api/logout`

Log out user and revoke token.

- **Headers**: Auth required.
- **Body**: None.

### 1.4 Email Verification

- **`POST /api/verify-email-code`**
    ```json
    {
        "email": "user@example.com",
        "code": "123456"
    }
    ```

    - **Validations**: `email` (Required), `code` (Required).
- **`POST /api/resend-verification-code`**
    ```json
    { "email": "user@example.com" }
    ```

    - **Validations**: `email` (Required, Exists in `users`).

---

## 2. Services

### 2.1 `GET /api/all-services`

Get all available services. (No Auth required).

### 2.2 `GET /api/services`

Get the authenticated user's main services.

### 2.3 `POST /api/services`

Create a new main service.

- **Content-Type**: `multipart/form-data`
- **Body Format**:
    - `name`: Required, String, Max 255
    - `description`: Optional, String
    - `price`: Required, Numeric, Min: 0
    - `category_id`: Required, Exists in `categories` table
    - `parent_service_id`: Optional, Exists in `services` table
    - `status`: Optional, String (`available` or `unavailable`)
    - `image_path`: Optional, Image File (png, jpg, jpeg, webp), Max: 2MB
    - `is_available`: Optional, Boolean (1/0)
    - `is_active`: Optional, Boolean (1/0)
    - `distance_based_price`: Optional, Boolean (1/0)
    - `price_per_km`: Optional, Numeric, Min: 0
    - `required_partial_percentage`: Required, Integer (0-100). Defines the % of total price needed to reach `accepted_partial_paid` status.

### 2.4 `PUT /api/services/{service_id}`

Update a main service. (Requires Auth).

- **Body Format**: Same as POST, but all fields are `Optional`. If uploading image, use `POST` with `_method=PUT` or adjust backend.

### 2.5 `POST /api/services/children`

Create a sub-service linked to a parent main service.

- **Content-Type**: `multipart/form-data`
    - `parent_service_id`: Required, Exists in `services`
    - `name`: Required, String, Max 255
    - `description`: Optional, String
    - `price`: Required, Numeric, Min 0
    - `image_path`: Optional, Image.

### 2.6 `PUT /api/services/children/{child_service_id}`

Update a child service.

- **Body**: `name`, `description`, `price`, `image_path` (All strictly optional).

### 2.7 `PUT /api/services/type/{type}`

Update the provider's unique custom or meeting service.

- **URL Param**: `type` (`custom` or `meeting`)
- **Body**: `name`, `description`, `price`, `category_id`, `status`, `is_available`, etc. (All Optional).

---

## 3. Profiles & Phones

### 3.1 `POST /api/profiles`

Create a user profile.

- **Content-Type**: `multipart/form-data`
    - `bio`: Optional, String, Max: 10000
    - `image`: Optional, Image (png, jpg, jpeg, webp), Max: 2MB

### 3.2 `POST /api/profile-phones`

Add a new phone number.

- **Body (`application/json`)**
    ```json
    { "phone": "0501234567" }
    ```

    - **Validations**: `phone` (Required, String, Max: 255).

---

## 4. Requests (Orders)

### 4.1 `POST /api/requests`

Create a new main service request.

- **Body (`application/json`)**

```json
{
    "service_id": 1,
    "message": "I need help with...",
    "latitude": 24.7136,
    "longitude": 46.6753,
    "sup_services": [
        {
            "id": 5,
            "quantity": 2
        }
    ]
}
```

- **Validations**:
    - `service_id`: Required, Exists in `services`.
    - `message`, `latitude`, `longitude`: Optional. 
    > [!NOTE]
    > If `latitude`/`longitude` are missing, the system defaults to the seeker's profile coordinates to calculate distance-based pricing.
    - `sup_services`: Optional, Array.
    - `sup_services.*.id`: Required if array provided, Exists in `services`.
    - `sup_services.*.quantity`: Integer, Min: 1.

### 4.2 `POST /api/requests/meeting`

Create a new meeting service request.

- **Body (`application/json`)**
```json
{
    "provider_id": 1,
    "message": "Let's set up a meeting.",
    "latitude": 24.7136,
    "longitude": 46.6753
}
```
- **Validations**:
    - `provider_id`: Required, Exists in `users`.
    - `message`: Optional, String.
    - `latitude`: Optional, Numeric (Needed for distance cost calc if enabled).
    - `longitude`: Optional, Numeric (Needed for distance cost calc if enabled).

### 4.3 `POST /api/requests/custom`

Create a new custom service request.

- **Body (`application/json`)**
```json
{
    "provider_id": 1,
    "message": "Custom request details...",
    "latitude": 24.7136,
    "longitude": 46.6753
}
```
- **Validations**:
    - `provider_id`: Required, Exists in `users`.
    - `message`: Required, String.
    - `latitude`, `longitude`: Optional, Numeric.

### 4.4 `GET /api/requests/custom-provider`

Get all custom service requests assigned to the authenticated provider.

### 4.5 `PATCH /api/requests/custom/{request_id}/price`

Provider accepts a custom request and sets the price.

- **Body (`application/json`)**
```json
{ "price": 500.00 }
```
- **Action**: Sets `total_price` and updates status to `accepted_initial`.

### 4.6 `PATCH /api/requests/custom/{request_id}/reject`

Provider rejects a custom request.

- **Action**: Updates status to `rejected`.

### 4.8 `GET /api/requests/{request_id}`

Get details of a specific request.

- **Response Includes**: `user`, `main_service`, `sub_services`, `bonds`, and `required_partial_amount` (The calculated amount needed to reach partial payment status).

### 4.9 `PATCH /api/requests/{request_id}/status`

Update status of a request.

- **Body (`application/json`)**

```json
{ "status": "accepted_initial" }
```

- **Validations**: `status` (Required, In allowed request statuses strings).

---

## 5. Provider Management & Work History

### 5.1 `POST /api/provider-requests`

Send a request to become a provider or log interaction.

- **Content-Type**: `multipart/form-data`
    - `name`: Required, String, Max: 150
    - `location`: Required, String, Max: 150
    - `requestContent`: Required, String, Max: 2000
    - `id_card`: Required, Image (jpg, jpeg, png), Max: 10MB

### 5.2 `POST /api/previous-work`

Add a new previous work item to portfolio.

- **Content-Type**: `multipart/form-data`
    - `title`: Required, String, Max: 255
    - `description`: Required, String
    - `image`: Required, Image, Max: 2MB

---

## 6. Financial & Bonds

### 6.1 `POST /api/user-bank`

Add a bank account for the user.

- **Body (`application/json`)**

```json
{
    "bank_id": 1,
    "bank_account": 1234567890
}
```

- **Validations**: `bank_id` (Required, exists in banks), `bank_account` (Required, Integer, Unique per user-bank).

### 6.2 `POST /api/request-bonds`

Upload a payment bond/receipt for a request.

- **Content-Type**: `multipart/form-data`
    - `request_id`: Required, exists in requests.
    - `image_path`: Required, Image file, Max: 2MB.
    - `bond_number`: Optional, Integer.
    - `description`: Optional, String.

### 6.3 `POST /api/request-commission-bonds`

Upload a commission bond.

- **Content-Type**: `multipart/form-data`
    - Same validations as `request-bonds` (`request_id`, `image`, `bond_number`, `description`).

---

## 7. Reviews & Complaints

### 7.1 `POST /api/reviews`

Review a completed request.

- **Body (`application/json`)**

```json
{
    "request_id": 1,
    "rating": 5,
    "comment": "Great service!"
}
```

- **Validations**: `request_id` (Exists), `rating` (Numeric, Min:1, Max:5), `comment` (String, Max:2000).

### 7.2 `POST /api/system-complaints`

Submit a complaint to admins.

- **Body (`application/json`)**

```json
{
    "title": "Issue with app",
    "content": "The app crashed when...",
    "type": "technical"
}
```

- **Validations**: `title` (Required, String, Max:255), `content` (Required, String), `type` (Required, Max:200).

---

## 8. Identity Verification Packages

### 8.1 `POST /api/user-verification-packages`

Submit a request for identity verification (e.g., to become a Pro Provider).

- **Content-Type**: `multipart/form-data`
    - `verification_package_id`: Required, exists in `verification_packages`.
    - `image_bond`: Required, Image file (Identity Card/Selfie), Max: 2MB.
    - `number_bond`: Required, String (Bond/Transaction Number).

- **Security**: The `number_bond` and `image_bond` are checked against the Central Bond Registry. Duplicate numbers or identical images will be rejected.

### 8.2 `GET /api/user-verification-packages`

Get the authenticated user's verification requests.

---

## 9. Payment Methods

### 9.1 `POST /api/requests/{id}/payByPoints`

Pay for a request using seeker's bonus points.

- **Body (`application/json`)**
```json
{ "transferred_points": 100 }
```
- **Logic**: Deducts from Seeker's `bonus_points` and adds to Provider's `paid_points`. Transitions status based on threshold.

### 9.2 `POST /api/requests/{id}/addAmountToMoneyPaid`

Manually add payment amount (e.g., via bank bond).

- **Body (`application/json`)**
```json
{ "amount": 150.50 }
```

---

## 10. Withdrawals (Provider Profits)

### 10.1 `POST /api/withdraw-request`

Submit a request to withdraw `paid_points`.

- **Body (`application/json`)**
```json
{ "amount": 1000 }
```
- **Validations**: `amount` (Required, Numeric, Min: 1, Max: User's `paid_points`).

### 10.2 `GET /api/my-withdraw-requests`

Get user's withdrawal requests and their statuses.

---

## 11. Points Packages (Buying Points)

### 11.1 `GET /api/available-points-packages`

List all available points packages for purchase.

### 11.2 `POST /api/subscribe-points-package`

Subscribe to a points package by uploading a payment bond.

- **Content-Type**: `multipart/form-data`
    - `package_id`: Required, exists in `points_packages`.
    - `bond_number`: Required, String.
    - `bank_name`: Required, String.
    - `bond_image`: Required, Image file, Max: 2MB.

---

## 🛡️ Security: Central Bond Registry

All endpoints that involve uploading a payment bond (`request-bonds`, `user-verification-packages`, `subscribe-points-package`) are protected by a **Central Bond Registry**:

1. **Uniqueness**: The `bond_number` must be unique across the entire system.
2. **Anti-Fraud (Hashing)**: The system generates a digital fingerprint for every uploaded image. If the exact same image is uploaded twice (even with a different bond number), the request will be rejected.
3. **Transaction Logging**: All point movements are logged in `point_transactions` for financial auditing.
