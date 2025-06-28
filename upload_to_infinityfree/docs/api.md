# AuraEdition API Documentation

## 🌐 API Overview

The AuraEdition API provides programmatic access to the e-commerce platform's functionality. This REST API enables third-party integrations, mobile applications, and automated systems to interact with the platform securely and efficiently.

### API Characteristics
- **Base URL**: `https://api.auraedition.com/v1`
- **Protocol**: HTTPS only
- **Format**: JSON request/response
- **Authentication**: Bearer token (JWT)
- **Rate Limiting**: 1000 requests per hour per API key
- **Versioning**: URL-based versioning (`/v1/`, `/v2/`)

---

## 🔐 Authentication

### API Key Authentication

#### Obtaining API Keys
```bash
# Request API key (Admin only)
POST /v1/auth/api-keys
Authorization: Bearer {admin_token}
Content-Type: application/json

{
    "name": "Mobile App Integration",
    "permissions": ["read:products", "read:orders", "write:orders"]
}
```

#### Using API Keys
```bash
# Include API key in headers
curl -H "Authorization: Bearer {api_key}" \
     -H "Content-Type: application/json" \
     https://api.auraedition.com/v1/products
```

### JWT Token Authentication

#### Login and Token Generation
```bash
# User login
POST /v1/auth/login
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "secure_password"
}

# Response
{
    "success": true,
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
    "expires_at": "2024-01-01T12:00:00Z",
    "user": {
        "id": 123,
        "email": "user@example.com",
        "role": "user"
    }
}
```

#### Token Usage
```bash
# Include JWT token in headers
curl -H "Authorization: Bearer {jwt_token}" \
     -H "Content-Type: application/json" \
     https://api.auraedition.com/v1/user/profile
```

---

## 📋 API Endpoints

### Authentication Endpoints

#### POST /v1/auth/login
**Purpose**: User authentication and token generation

**Request**:
```json
{
    "email": "user@example.com",
    "password": "secure_password"
}
```

**Response**:
```json
{
    "success": true,
    "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
    "expires_at": "2024-01-01T12:00:00Z",
    "user": {
        "id": 123,
        "fname": "John",
        "lname": "Doe",
        "email": "user@example.com",
        "role": "user"
    }
}
```

#### POST /v1/auth/register
**Purpose**: User registration

**Request**:
```json
{
    "fname": "John",
    "lname": "Doe",
    "email": "user@example.com",
    "password": "secure_password",
    "address": "123 Main St",
    "city": "New York",
    "state": "NY"
}
```

**Response**:
```json
{
    "success": true,
    "message": "User registered successfully",
    "user": {
        "id": 123,
        "fname": "John",
        "lname": "Doe",
        "email": "user@example.com"
    }
}
```

#### POST /v1/auth/refresh
**Purpose**: Refresh expired JWT token

**Request**:
```json
{
    "refresh_token": "refresh_token_here"
}
```

**Response**:
```json
{
    "success": true,
    "token": "new_jwt_token_here",
    "expires_at": "2024-01-01T12:00:00Z"
}
```

### Product Endpoints

#### GET /v1/products
**Purpose**: Retrieve product catalog with filtering and pagination

**Query Parameters**:
- `page`: Page number (default: 1)
- `limit`: Items per page (default: 20, max: 100)
- `make_id`: Filter by vehicle make
- `model_id`: Filter by vehicle model
- `min_price`: Minimum price filter
- `max_price`: Maximum price filter
- `status`: Product status (active, inactive, sold)
- `featured`: Featured products only (true/false)
- `popular`: Popular products only (true/false)
- `search`: Search in title and description

**Request**:
```bash
GET /v1/products?page=1&limit=20&make_id=1&min_price=50000&status=active
```

**Response**:
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "title": "2023 BMW M3 Competition",
            "description": "Luxury sports sedan with premium features...",
            "price": 85000.00,
            "stock": 1,
            "status": "active",
            "is_featured": true,
            "is_popular": false,
            "created_at": "2023-12-01T10:00:00Z",
            "make": {
                "id": 1,
                "name": "BMW",
                "image": "/assets/images/makes/bmw.png"
            },
            "model": {
                "id": 5,
                "name": "M3 Competition"
            },
            "images": [
                {
                    "id": 1,
                    "url": "/products/img/bmw-m3-1.jpg",
                    "alt": "BMW M3 Front View"
                }
            ]
        }
    ],
    "pagination": {
        "current_page": 1,
        "total_pages": 5,
        "total_items": 100,
        "items_per_page": 20
    }
}
```

#### GET /v1/products/{id}
**Purpose**: Retrieve detailed product information

**Request**:
```bash
GET /v1/products/1
```

**Response**:
```json
{
    "success": true,
    "data": {
        "id": 1,
        "title": "2023 BMW M3 Competition",
        "description": "Detailed product description...",
        "price": 85000.00,
        "stock": 1,
        "status": "active",
        "is_featured": true,
        "is_popular": false,
        "created_at": "2023-12-01T10:00:00Z",
        "make": {
            "id": 1,
            "name": "BMW",
            "image": "/assets/images/makes/bmw.png"
        },
        "model": {
            "id": 5,
            "name": "M3 Competition"
        },
        "images": [
            {
                "id": 1,
                "url": "/products/img/bmw-m3-1.jpg",
                "alt": "BMW M3 Front View"
            },
            {
                "id": 2,
                "url": "/products/img/bmw-m3-2.jpg",
                "alt": "BMW M3 Side View"
            }
        ],
        "specifications": {
            "year": 2023,
            "mileage": 0,
            "engine": "3.0L Twin-Turbo I6",
            "transmission": "8-Speed Automatic",
            "drivetrain": "RWD"
        }
    }
}
```

### Category Endpoints

#### GET /v1/categories
**Purpose**: Retrieve vehicle makes and models

**Request**:
```bash
GET /v1/categories
```

**Response**:
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "BMW",
            "image": "/assets/images/makes/bmw.png",
            "listings_count": 15,
            "models": [
                {
                    "id": 5,
                    "name": "M3 Competition",
                    "listings_count": 3
                },
                {
                    "id": 6,
                    "name": "X5 M",
                    "listings_count": 2
                }
            ]
        }
  ]
}
```

#### GET /v1/categories/{id}/products
**Purpose**: Retrieve products by category

**Request**:
```bash
GET /v1/categories/1/products?page=1&limit=20
```

**Response**:
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "title": "2023 BMW M3 Competition",
            "price": 85000.00,
            "image": "/products/img/bmw-m3-1.jpg"
        }
    ],
    "pagination": {
        "current_page": 1,
        "total_pages": 1,
        "total_items": 15,
        "items_per_page": 20
    }
}
```

### User Endpoints

#### GET /v1/user/profile
**Purpose**: Retrieve user profile information

**Authentication**: Required (JWT)

**Request**:
```bash
GET /v1/user/profile
Authorization: Bearer {jwt_token}
```

**Response**:
```json
{
    "success": true,
    "data": {
        "id": 123,
        "fname": "John",
        "lname": "Doe",
        "email": "user@example.com",
        "role": "user",
        "registered_date": "2023-01-01T10:00:00Z",
        "address": {
            "address": "123 Main St",
            "city": "New York",
            "state": "NY",
            "country": "USA"
        }
    }
}
```

#### PUT /v1/user/profile
**Purpose**: Update user profile

**Authentication**: Required (JWT)

**Request**:
```json
{
    "fname": "John",
    "lname": "Smith",
    "address": "456 Oak Ave",
    "city": "Los Angeles",
    "state": "CA"
}
```

**Response**:
```json
{
    "success": true,
    "message": "Profile updated successfully"
}
```

### Cart Endpoints

#### GET /v1/cart
**Purpose**: Retrieve user's shopping cart

**Authentication**: Required (JWT)

**Request**:
```bash
GET /v1/cart
Authorization: Bearer {jwt_token}
```

**Response**:
```json
{
    "success": true,
    "data": {
        "items": [
            {
                "id": 1,
                "vehicle_id": 1,
                "title": "2023 BMW M3 Competition",
                "price": 85000.00,
                "quantity": 1,
                "image": "/products/img/bmw-m3-1.jpg"
            }
        ],
        "total_items": 1,
        "total_price": 85000.00
    }
}
```

#### POST /v1/cart/items
**Purpose**: Add item to cart

**Authentication**: Required (JWT)

**Request**:
```json
{
    "vehicle_id": 1,
    "quantity": 1
}
```

**Response**:
```json
{
    "success": true,
    "message": "Item added to cart successfully"
}
```

#### PUT /v1/cart/items/{id}
**Purpose**: Update cart item quantity

**Authentication**: Required (JWT)

**Request**:
```json
{
    "quantity": 2
}
```

**Response**:
```json
{
    "success": true,
    "message": "Cart updated successfully"
}
```

#### DELETE /v1/cart/items/{id}
**Purpose**: Remove item from cart

**Authentication**: Required (JWT)

**Response**:
```json
{
    "success": true,
    "message": "Item removed from cart successfully"
}
```

#### DELETE /v1/cart
**Purpose**: Clear entire cart

**Authentication**: Required (JWT)

**Response**:
```json
{
    "success": true,
    "message": "Cart cleared successfully"
}
```

### Wishlist Endpoints

#### GET /v1/wishlist
**Purpose**: Retrieve user's wishlist

**Authentication**: Required (JWT)

**Request**:
```bash
GET /v1/wishlist?page=1&limit=20
Authorization: Bearer {jwt_token}
```

**Response**:
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "vehicle_id": 1,
            "title": "2023 BMW M3 Competition",
            "price": 85000.00,
            "image": "/products/img/bmw-m3-1.jpg",
            "added_at": "2023-12-01T10:00:00Z"
        }
    ],
    "pagination": {
        "current_page": 1,
        "total_pages": 1,
        "total_items": 5,
        "items_per_page": 20
    }
}
```

#### POST /v1/wishlist/items
**Purpose**: Add item to wishlist

**Authentication**: Required (JWT)

**Request**:
```json
{
    "vehicle_id": 1
}
```

**Response**:
```json
{
    "success": true,
    "message": "Item added to wishlist successfully"
}
```

#### DELETE /v1/wishlist/items/{id}
**Purpose**: Remove item from wishlist

**Authentication**: Required (JWT)

**Response**:
```json
{
    "success": true,
    "message": "Item removed from wishlist successfully"
}
```

### Order Endpoints

#### GET /v1/orders
**Purpose**: Retrieve user's order history

**Authentication**: Required (JWT)

**Request**:
```bash
GET /v1/orders?page=1&limit=20
Authorization: Bearer {jwt_token}
```

**Response**:
```json
{
    "success": true,
    "data": [
        {
            "id": "ORD-2023-001",
            "total_price": 85000.00,
            "status": "delivered",
            "ordered_at": "2023-12-01T10:00:00Z",
            "items": [
                {
                    "vehicle_id": 1,
                    "title": "2023 BMW M3 Competition",
                    "price": 85000.00,
                    "quantity": 1
                }
            ]
        }
    ],
    "pagination": {
        "current_page": 1,
        "total_pages": 1,
        "total_items": 3,
        "items_per_page": 20
    }
}
```

#### GET /v1/orders/{id}
**Purpose**: Retrieve specific order details

**Authentication**: Required (JWT)

**Request**:
```bash
GET /v1/orders/ORD-2023-001
Authorization: Bearer {jwt_token}
```

**Response**:
```json
{
    "success": true,
    "data": {
        "id": "ORD-2023-001",
        "total_price": 85000.00,
        "status": "delivered",
        "ordered_at": "2023-12-01T10:00:00Z",
        "shipping_address": {
            "address": "123 Main St",
            "city": "New York",
            "state": "NY",
            "country": "USA"
        },
        "items": [
            {
                "vehicle_id": 1,
                "title": "2023 BMW M3 Competition",
                "price": 85000.00,
                "quantity": 1,
                "image": "/products/img/bmw-m3-1.jpg"
            }
        ]
    }
}
```

#### POST /v1/orders
**Purpose**: Create new order from cart

**Authentication**: Required (JWT)

**Request**:
```json
{
    "payment_method": "credit_card",
    "shipping_address": {
        "address": "123 Main St",
        "city": "New York",
        "state": "NY",
        "country": "USA"
    }
}
```

**Response**:
```json
{
    "success": true,
    "data": {
        "order_id": "ORD-2023-002",
        "total_price": 85000.00,
        "status": "pending",
        "payment_url": "https://payment.auraedition.com/pay/ORD-2023-002"
    }
}
```

### Admin Endpoints

#### GET /v1/admin/dashboard
**Purpose**: Retrieve admin dashboard statistics

**Authentication**: Required (Admin JWT)

**Request**:
```bash
GET /v1/admin/dashboard
Authorization: Bearer {admin_jwt_token}
```

**Response**:
```json
{
    "success": true,
    "data": {
        "total_revenue": 1250000.00,
        "total_listings": 150,
        "total_orders": 45,
        "total_users": 1200,
        "recent_orders": [
            {
                "id": "ORD-2023-002",
                "user_name": "John Doe",
                "total_price": 85000.00,
                "status": "pending"
            }
        ],
        "sales_chart": {
            "labels": ["Jan", "Feb", "Mar", "Apr"],
            "data": [250000, 300000, 280000, 320000]
        }
    }
}
```

#### GET /v1/admin/products
**Purpose**: Retrieve products for admin management

**Authentication**: Required (Admin JWT)

**Request**:
```bash
GET /v1/admin/products?page=1&limit=20&search=BMW&status=active
Authorization: Bearer {admin_jwt_token}
```

**Response**:
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "title": "2023 BMW M3 Competition",
            "price": 85000.00,
            "stock": 1,
            "status": "active",
            "make_name": "BMW",
            "created_at": "2023-12-01T10:00:00Z"
        }
    ],
    "pagination": {
        "current_page": 1,
        "total_pages": 5,
        "total_items": 100,
        "items_per_page": 20
    }
}
```

#### POST /v1/admin/products
**Purpose**: Create new product

**Authentication**: Required (Admin JWT)

**Request**:
```json
{
    "title": "2024 Mercedes AMG GT",
    "description": "Luxury sports car with premium features...",
    "price": 120000.00,
    "stock": 1,
    "make_id": 2,
    "model_id": 10,
    "is_featured": true,
    "is_popular": false
}
```

**Response**:
```json
{
    "success": true,
    "data": {
        "id": 2,
        "title": "2024 Mercedes AMG GT",
        "price": 120000.00,
        "created_at": "2023-12-01T11:00:00Z"
    }
}
```

---

## 📊 Error Handling

### Error Response Format

All API endpoints return consistent error responses:

```json
{
    "success": false,
    "error": {
        "code": "VALIDATION_ERROR",
        "message": "Invalid input data",
        "details": {
            "email": "Invalid email format",
            "password": "Password must be at least 8 characters"
        }
    }
}
```

### Common Error Codes

| Code | Description | HTTP Status |
|------|-------------|-------------|
| `AUTHENTICATION_FAILED` | Invalid credentials | 401 |
| `AUTHORIZATION_FAILED` | Insufficient permissions | 403 |
| `VALIDATION_ERROR` | Invalid input data | 400 |
| `NOT_FOUND` | Resource not found | 404 |
| `RATE_LIMIT_EXCEEDED` | Too many requests | 429 |
| `INTERNAL_ERROR` | Server error | 500 |

### Rate Limiting

```json
{
    "success": false,
    "error": {
        "code": "RATE_LIMIT_EXCEEDED",
        "message": "Rate limit exceeded",
        "details": {
            "limit": 1000,
            "reset_time": "2023-12-01T12:00:00Z"
        }
    }
}
```

---

## 🔧 SDKs and Libraries

### PHP SDK

```php
<?php
require_once 'vendor/autoload.php';

use AuraEdition\Api\Client;

$client = new Client([
    'api_key' => 'your_api_key',
    'base_url' => 'https://api.auraedition.com/v1'
]);

// Get products
$products = $client->products()->list([
    'page' => 1,
    'limit' => 20,
    'make_id' => 1
]);

// Create order
$order = $client->orders()->create([
    'vehicle_id' => 1,
    'quantity' => 1
]);
?>
```

### JavaScript SDK

```javascript
import { AuraEditionAPI } from '@auraedition/api';

const api = new AuraEditionAPI({
    apiKey: 'your_api_key',
    baseURL: 'https://api.auraedition.com/v1'
});

// Get products
const products = await api.products.list({
    page: 1,
    limit: 20,
    make_id: 1
});

// Create order
const order = await api.orders.create({
    vehicle_id: 1,
    quantity: 1
});
```

### Python SDK

```python
from auraedition import AuraEditionAPI

api = AuraEditionAPI(
    api_key='your_api_key',
    base_url='https://api.auraedition.com/v1'
)

# Get products
products = api.products.list(
    page=1,
    limit=20,
    make_id=1
)

# Create order
order = api.orders.create(
    vehicle_id=1,
    quantity=1
)
```

---

## 📈 Webhooks

### Webhook Configuration

```bash
# Register webhook
POST /v1/webhooks
Authorization: Bearer {admin_jwt_token}
Content-Type: application/json

{
    "url": "https://your-app.com/webhooks/auraedition",
    "events": ["order.created", "order.updated", "product.updated"],
    "secret": "your_webhook_secret"
}
```

### Webhook Events

#### order.created
```json
{
    "event": "order.created",
    "timestamp": "2023-12-01T10:00:00Z",
    "data": {
        "order_id": "ORD-2023-002",
        "user_id": 123,
        "total_price": 85000.00,
        "status": "pending"
    }
}
```

#### order.updated
```json
{
    "event": "order.updated",
    "timestamp": "2023-12-01T11:00:00Z",
    "data": {
        "order_id": "ORD-2023-002",
        "status": "processing",
        "previous_status": "pending"
    }
}
```

#### product.updated
```json
{
    "event": "product.updated",
    "timestamp": "2023-12-01T12:00:00Z",
    "data": {
        "product_id": 1,
        "title": "Updated Product Title",
        "price": 90000.00,
        "stock": 0
    }
}
```

### Webhook Verification

```php
<?php
// Verify webhook signature
function verifyWebhook($payload, $signature, $secret) {
    $expected = hash_hmac('sha256', $payload, $secret);
    return hash_equals($expected, $signature);
}

$signature = $_SERVER['HTTP_X_AURAEDITION_SIGNATURE'];
$payload = file_get_contents('php://input');

if (verifyWebhook($payload, $signature, $webhook_secret)) {
    // Process webhook
    $data = json_decode($payload, true);
    processWebhook($data);
} else {
    http_response_code(401);
    echo "Invalid signature";
}
?>
```

---

## 🚀 Integration Examples

### Mobile App Integration

```javascript
// React Native example
import { AuraEditionAPI } from '@auraedition/api';

const api = new AuraEditionAPI({
    apiKey: 'mobile_app_api_key'
});

// Browse products
const browseProducts = async () => {
    try {
        const products = await api.products.list({
            page: 1,
            limit: 20,
            featured: true
        });
        
        return products.data;
    } catch (error) {
        console.error('Error fetching products:', error);
        throw error;
    }
};

// User authentication
const login = async (email, password) => {
    try {
        const response = await api.auth.login({
            email,
            password
        });
        
        // Store token securely
        await SecureStore.setItemAsync('auth_token', response.token);
        
        return response.user;
    } catch (error) {
        console.error('Login failed:', error);
        throw error;
    }
};
```

### E-commerce Platform Integration

```php
<?php
// WordPress/WooCommerce integration
class AuraEditionIntegration {
    private $api;
    
    public function __construct() {
        $this->api = new AuraEditionAPI([
            'api_key' => get_option('auraedition_api_key'),
            'base_url' => 'https://api.auraedition.com/v1'
        ]);
    }
    
    public function syncProducts() {
        $page = 1;
        $all_products = [];
        
        do {
            $response = $this->api->products->list([
                'page' => $page,
                'limit' => 100,
                'status' => 'active'
            ]);
            
            $all_products = array_merge($all_products, $response['data']);
            $page++;
            
        } while ($page <= $response['pagination']['total_pages']);
        
        // Create/update WooCommerce products
        foreach ($all_products as $product) {
            $this->createOrUpdateProduct($product);
        }
    }
    
    private function createOrUpdateProduct($api_product) {
        $wc_product = wc_get_product_by_sku($api_product['id']);
        
        if (!$wc_product) {
            $wc_product = new WC_Product_Simple();
        }
        
        $wc_product->set_name($api_product['title']);
        $wc_product->set_description($api_product['description']);
        $wc_product->set_price($api_product['price']);
        $wc_product->set_regular_price($api_product['price']);
        $wc_product->set_sku($api_product['id']);
        $wc_product->set_status($api_product['status'] === 'active' ? 'publish' : 'draft');
        
        $wc_product->save();
    }
}
?>
```

### Analytics Integration

```python
# Analytics dashboard integration
import requests
from datetime import datetime, timedelta

class AuraEditionAnalytics:
    def __init__(self, api_key):
        self.api_key = api_key
        self.base_url = 'https://api.auraedition.com/v1'
        self.headers = {'Authorization': f'Bearer {api_key}'}
    
    def get_dashboard_stats(self):
        """Get dashboard statistics for analytics"""
        response = requests.get(
            f'{self.base_url}/admin/dashboard',
            headers=self.headers
        )
        
        if response.status_code == 200:
            return response.json()['data']
        else:
            raise Exception(f'API Error: {response.status_code}')
    
    def get_sales_data(self, days=30):
        """Get sales data for the last N days"""
        end_date = datetime.now()
        start_date = end_date - timedelta(days=days)
        
        # This would require additional API endpoints for detailed analytics
        # Implementation depends on available analytics endpoints
        
        return {
            'start_date': start_date.isoformat(),
            'end_date': end_date.isoformat(),
            'total_sales': 0,
            'total_orders': 0,
            'average_order_value': 0
        }
    
    def export_data(self, data_type, start_date, end_date):
        """Export data for external analytics"""
        params = {
            'type': data_type,
            'start_date': start_date.isoformat(),
            'end_date': end_date.isoformat(),
            'format': 'csv'
        }
        
        response = requests.get(
            f'{self.base_url}/admin/export',
            headers=self.headers,
            params=params
        )
        
        if response.status_code == 200:
            return response.content
        else:
            raise Exception(f'Export failed: {response.status_code}')
```

---

## 📚 API Versioning

### Version Strategy

The API uses URL-based versioning:
- **Current Version**: `/v1/`
- **Future Versions**: `/v2/`, `/v3/`, etc.
- **Deprecation**: 12-month notice before version removal

### Migration Guide

#### From v1 to v2 (Future)
```bash
# v1 endpoint (deprecated)
GET /v1/products

# v2 endpoint (new)
GET /v2/products

# Changes in v2:
# - Enhanced filtering options
# - Improved pagination
# - Additional product fields
# - Better error handling
```

---

This comprehensive API documentation provides everything needed to integrate with the AuraEdition platform. The API is designed to be RESTful, secure, and developer-friendly while supporting various use cases from mobile apps to enterprise integrations. 