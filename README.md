# e-commarce

Front Controller - Layered Architecture - RESTFull - Rich Domain Model - Redis - MySql - Apache Kafka

# API Routes Documentation

This document describes the available routes in the application, grouped by their respective functionalities, along with a brief explanation of their purpose.

## Auth Routes

- **POST /auth/register** - Registers a new user.
- **GET /auth/verify-user-acc** - Verifies a user's account.
- **POST /auth/login** - Logs a user into the application.
- **POST /auth/refresh-token** - Refreshes the authentication token.

## User Routes

- **GET /users** - Lists all users.
- **PATCH /users/password** - Updates a user's password.
- **POST /users/send-forgetten-password-email** - Sends a forgotten password email.
- **PATCH /users/forgetten-password** - Resets a forgotten password.
- **GET /users/{uuid}** - Retrieves a user by their UUID.
- **PATCH /users/fullname** - Updates a user's full name.

## Category Routes

- **PUT /categories/{uuid}** - Updates a category's name by its UUID.
- **DELETE /categories/{uuid}** - Deletes a category by its UUID.
- **POST /categories** - Creates a new category.
- **GET /categories** - Retrieves all categories.
- **GET /categories/{uuid}** - Retrieves a single category by its UUID.

## Brand Routes

- **GET /brands** - Retrieves all brands.
- **GET /brands/{uuid}** - Retrieves a brand with its models by UUID.
- **POST /brands** - Creates a new brand.
- **POST /brands/{uuid}/model** - Creates a model under a specific brand.
- **PATCH /brands/{uuid}** - Updates a brand's name.
- **PATCH /brands/{uuid}/model/{modelUuid}** - Updates a brand model's name.
- **DELETE /brands/{uuid}** - Deletes a brand by UUID.

## Product Routes

- **GET /products/search** - Searches for products based on criteria.
- **GET /products** - Retrieves products by specific criteria.
- **GET /products/{uuid}** - Retrieves a single product by UUID.
- **POST /products/{uuid}/subscriber** - Subscribes to a product.
- **POST /products** - Creates a new product.
- **PATCH /products/{uuid}/stock-quantity** - Updates a product's stock quantity.
- **PUT /products/{uuid}** - Updates product details.
- **DELETE /products/{uuid}** - Deletes a product by UUID.
- **DELETE /products/{uuid}/subscriber** - Removes a product subscriber.
- **POST /products/{uuid}/review** - Adds a review for a product.
- **PATCH /products/{uuid}/comment** - Updates a product comment.
- **PATCH /products/{uuid}/rate** - Updates a product's rating.
- **DELETE /products/{uuid}/review** - Deletes a product review.

## Upload Routes

- **POST /uploads/{uuid}/image** - Uploads an image for a product.
- **DELETE /uploads/{uuid}/image/{imageUuid}/product** - Deletes a product's image by UUID.

## Order Routes

- **POST /orders** - Places a new order.
- **POST /orders/{uuid}/dispatch** - Dispatches an order.
- **POST /orders/{uuid}/complete** - Marks an order as complete.
- **POST /orders/{uuid}/cancel** - Cancels an order.
- **POST /orders/{uuid}/return-request** - Sends a return request for an order.
- **POST /orders/{uuid}/return** - Processes an order return.
- **GET /orders/{uuid}/user** - Retrieves all orders for a user by UUID.

## Shipping Routes

- **GET /shippings** - Retrieves all available shipping methods.
- **GET /shippings/{uuid}** - Retrieves a specific shipping method by UUID.
- **POST /shippings/{uuid}/deliver** - Marks a shipping as delivered.
