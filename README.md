# Order & Payment Management API

A Laravel-based RESTful API for managing orders and payments with a clean, modular architecture and extensible payment gateway system.

---

## 🚀 Features

-   JWT Authentication
-   Order management (CRUD)
-   Order items support
-   Payment processing
-   Extensible payment gateways (Strategy Pattern)
-   Pagination support
-   Feature & unit tests
-   Clean architecture (Controller → Service → Gateway)

---

## 🧰 Tech Stack

-   Laravel 12
-   PHP 8.2+
-   MySQL
-   JWT Auth (tymon/jwt-auth)
-   Postman

---

## ⚙️ Setup Instructions

### 1. Clone Repository

```bash
git clone https://github.com/ibrahimMohamed1990/order-payment-api.git
cd order-payment-api
```

Payment Gateway Extensibility (Design Explanation)

This project implements an extensible payment gateway system using the Strategy Pattern, allowing new payment methods to be added with minimal code changes.

🔹 Core Idea

Payment processing logic is decoupled from orders and controllers.
Each payment gateway implements a common interface, enabling the system to switch or extend payment methods dynamically.

🔹 Payment Gateway Interface

All payment gateways must implement a single contract:

interface PaymentGatewayInterface
{
public function charge(float $amount, array $data = []): PaymentResult;
}

This ensures:

Consistent behavior across gateways

Easy replacement or extension

Strong type safety

🔹 Concrete Gateway Implementations

Each payment method is implemented as a separate strategy:

CreditCardGateway
PaypalGateway

Example:

class CreditCardGateway implements PaymentGatewayInterface
{
public function charge(float $amount, array $data = []): PaymentResult
{
return new PaymentResult(success: true);
}
}

Each gateway encapsulates its own logic and is fully isolated from the rest of the system.

#Gateway Resolver (Factory)

A factory is responsible for resolving the correct gateway at runtime:

class PaymentGatewayFactory
{
public function make(string $method): PaymentGatewayInterface
}

This factory maps a payment method (e.g. credit_card, paypal) to its corresponding gateway class.

#Payment Processing Flow

API receives a payment request

PaymentService requests a gateway from the factory

The selected gateway processes the payment

The result determines:

Payment status (successful / failed)

Order status update (confirmed on success)

This flow keeps controllers thin and business logic centralized.

#Adding a New Payment Gateway

To add a new payment gateway (e.g. Stripe):

Create a new gateway class:

class StripeGateway implements PaymentGatewayInterface
{
public function charge(float $amount, array $data = []): PaymentResult
{
return new PaymentResult(true);
}
}

Register it in the factory:

'stripe' => StripeGateway::class

$$
No changes are required in:

Controllers

Services

Existing gateways

#Benefits of This Design

Follows Open/Closed Principle

Highly maintainable and testable

Supports future payment providers

Clean separation of concerns

Easy to mock and unit test

# Design Pattern Used

Strategy Pattern – to encapsulate and switch payment behaviors dynamically

Factory Pattern – to resolve payment strategies at runtime

$$ This approach ensures the payment system is scalable, clean, and production-ready.
$$
