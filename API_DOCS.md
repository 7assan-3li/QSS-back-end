# Complete System API Documentation (QSS)

This comprehensive document describes **ALL API endpoints** available in the system, including required request bodies, query parameters, expected responses, and validation rules.

## 0. General Requirements

All requests (except public endpoints like `register` and `login`) require standard headers to be authenticated by Laravel Sanctum:

```http
Accept: application/json
Authorization: Bearer {your_sanctum_token}
```

---

## 1. Authentication & Users

Endpoints related to user registration, login, and email verification.

### `POST /api/register`
Create a new user.
- **Body**: `name`, `email`, `password`, `password_confirmation`, `seeker_policy` (Accepted: true).

### `POST /api/login`
Authenticate a user and get a Bearer token.
- **Body**: `email`, `password`.

### `POST /api/logout`
Log out user and revoke token. Auth required.

### `POST /api/verify-email-code`
Verify user's email address using a code.
- **Body**: `email`, `code` (String).

### `POST /api/resend-verification-code`
Resend the OTP verification code to user email.
- **Body**: `email`.

### `PATCH /api/verify-email-admin/{id}`
Admin-only endpoint to instantly verify a user's email bypassing OTP.

---

## 2. Profiles & Portfolios

Manage user details, contact numbers, and past work portfolio.

### `POST /api/profiles`
Create the profile details for the authenticated user.
- **Body (multipart/form-data)**: `bio` (String), `image` (Max 2MB).

### `GET /api/profiles/{id}`
Retrieve a profile by profile ID.

### `PUT /api/profiles/{id}`
Update an existing profile.

### `GET /api/my-profile`
Get the authenticated user's profile with all relationships (phones, banks, works).

### `GET /api/user-profile/{user_id}`
Get a specific user's complete profile by their User ID.

### `GET /api/profile-phones`
List all phone numbers belonging to the user.

### `POST /api/profile-phones`
Add a new phone number to the profile.
- **Body**: `phone` (String).

### `PUT /api/profile-phones/{id}`
Update a specific phone number.
- **Body**: `phone` (String).

### `DELETE /api/profile-phones/{id}`
Remove a phone number.

### `GET /api/previous-work`
Retrieve the authenticated provider's portfolio (previous works).

### `POST /api/previous-work`
Upload a new portfolio item.
- **Body (multipart/form-data)**: `title`, `description`, `image`.

### `POST /api/previous-work/{id}?_method=PUT`
Update an existing portfolio item (use POST with `_method=PUT` for file uploads).

### `DELETE /api/previous-work/{id}`
Remove a portfolio item.

---

## 3. Services & Schedules

Manage categories, services, parent/child groupings, and time scheduling.

### `GET /api/categories`
List all system categories. (Public)

### `GET /api/all-services`
List all system services. (Public)

### `GET /api/services`
Get the authenticated provider's main services.

### `POST /api/services`
Create a main service.
- **Body (multipart/form-data)**: `name`, `description`, `price`, `category_id`, `image_path`, `required_partial_percentage` (0-100), `distance_based_price` (0/1), `price_per_km`.

### `GET /api/services/{service_id}`
Get details of a specific service including its current availability `is_available_now` and full `schedules`.

### `PUT /api/services/{service_id}`
Update a main service.

### `DELETE /api/services/{service_id}`
Delete a main service.

### `POST /api/services/children`
Create a sub-service linked to a parent service.
- **Body**: `parent_service_id`, `name`, `description`, `price`.

### `PUT /api/services/children/{child_service_id}`
Update a child service.

### `DELETE /api/services/children/{child_service_id}`
Delete a child service.

### `PUT /api/services/type/{type}`
Update the provider's unique auto-generated services (`custom` or `meeting`).

### `GET /api/favorites`
Get user's favorite services list.

### `POST /api/favorites/toggle`
Add or remove a service from favorites.
- **Body**: `service_id`.

### `GET /api/services/{serviceId}/schedules`
Get all schedules (time slots and days) for a specific service.

### `POST /api/services/schedules`
Create a work time slot for a service.
- **Body**: `service_id`, `label` (e.g., Morning Shift), `start_time` (H:i), `end_time` (H:i), `days` (Array of lowercase english days).

### `PUT /api/services/schedules/{id}`
Update a time slot and sync its assigned days.

### `DELETE /api/services/schedules/{id}`
Delete a time slot.

---

## 4. Requests (Orders)

Handling the full lifecycle of normal, meeting, and custom service requests.

### `GET /api/requests`
Get all requests belonging to the authenticated user.

### `POST /api/requests`
Create a standard request.
- **Body**: `service_id`, `message`, `latitude`, `longitude`, `sup_services` array (id, quantity).

### `GET /api/requests/{request_id}`
Show single request data (including bonds, sub-services, users).

### `GET /api/requests/{request_id}/status`
Get just the current string status of a request.

### `PATCH /api/requests/{request_id}/status`
Provider changes the progress status of the request (e.g., `in_progress`, `completed`).
- **Body**: `status` (String).

### `GET /api/requests/meeting-provider` / `meeting-seeker`
Get all meeting requests where user is the provider or seeker.

### `POST /api/requests/meeting`
Create a meeting request with a specific provider.
- **Body**: `provider_id`, `message`, `latitude`, `longitude`.

### `GET /api/requests/custom-provider` / `custom-seeker`
Get all custom requests for the user.

### `POST /api/requests/custom`
Create an open-ended request asking for a custom quote.
- **Body**: `provider_id`, `message`, `latitude`, `longitude`.

### `PATCH /api/requests/custom/{request}/price`
Provider analyzes the custom request and sets a final price.
- **Body**: `price` (Numeric). Changes status to `accepted_initial`.

### `PATCH /api/requests/custom/{request}/reject`
Provider rejects the custom request.

---

## 5. Payments, Points & Finance

Financial operations covering internal points to external bank transfers.

### `GET /api/banks`
List all official banks (Public).

### `GET /api/user-banks` `POST` `PUT` `GET /{id}`
Manage bank accounts belonging to the user (`bank_id`, `bank_account` number).

### `POST /api/requests/{id}/payByPoints`
Seeker pays for a request using their `bonus_points`.
- **Body**: `transferred_points` (Numeric).

### `POST /api/requests/{id}/addAmountToMoneyPaid`
Seeker marks manual cash payment against the request.
- **Body**: `amount`.

### `POST /api/requests/{id}/pay-commission`
Provider pays the platform commission automatically from their `bonus_points` followed by `paid_points`.

### `POST /api/request-commission-bonds`
Provider uploads an external receipt image if they do not have enough points to pay the platform commission.
- **Body (multipart/form-data)**: `request_id`, `image`, `amount` (Paid value), `bond_number` (Unique Reference).

### `POST /api/request-bonds`
Seeker uploads a bank transfer receipt to pay for the service itself.
- **Body (multipart/form-data)**: `request_id`, `image_path`, `amount`.

### `POST /api/withdraw-request`
Provider requests to withdraw their real earnings (`paid_points`) to their bank account.
- **Body**: `amount` (Numeric).

### `GET /api/my-withdraw-requests`
Track statuses of submitted withdrawal requests.

### `POST /api/points/convert`
Provider converts `paid_points` into `bonus_points` with a system-provided 1% incentive to pay commissions easily.
- **Body**: `amount` (Numeric).

---

## 6. Points Packages & Verification Subscriptions

### `GET /api/available-points-packages`
View list of bundles available to buy (e.g., 500 points for $50).

### `GET /api/my-points-packages`
See packages user has already subscribed to.

### `POST /api/subscribe-points-package`
User uploads a bond to buy a Points Package.

### `GET /api/verification-packages`
View identity tier packages (e.g., Bronze, Silver, Gold Provider).

### `POST /api/user-verification-packages`
Subscribe to a verification package by uploading an ID/selfie.
- **Body (multipart/form-data)**: `verification_package_id`, `image_bond`, `number_bond`.

---

## 7. Reviews, Complaints & Meta

### `POST /api/reviews`
Review a completed request.
- **Body**: `request_id`, `rating` (1-5), `comment`.

### `POST /api/request-complaints`
Complain about an issue inside a specific request.
- **Body**: `request_id`, `reason_for_complaint`.

### `POST /api/system-complaints`
General system, technical, or broad complaints.
- **Body**: `title`, `content`, `type`.

### `POST /api/store-token`
Save the Firebase/FCM device token for mobile Push Notifications.

### `GET /api/notifications`
Get a paginated list of all mobile/system notifications for the user.

### `DELETE /api/notifications/{id}`
Delete a single notification from the tray.

---

> [!CAUTION]
> **Bond Registry Security Mechanism**
>
> To eliminate fraud, any endpoint that accepts an image bond or receipt (e.g., `request-bonds`, `request-commission-bonds`, `subscribe-points-package`) validates the file signature inside the **Central Bond Registry**. Uploading the same exact image for two different payments will result in instant rejection by the server.
