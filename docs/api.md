# API Planning & Reference (Future)

## Overview
A RESTful API is planned for external integrations and SPA/mobile clients.

## Authentication
- JWT or session-based authentication
- API keys for external partners
- Rate limiting for public endpoints

## Endpoints (Planned)
- `GET /api/vehicles` – List vehicles
- `GET /api/vehicles/{id}` – Get vehicle details
- `POST /api/orders` – Create order (auth required)
- `GET /api/orders` – List user orders (auth required)
- `GET /api/users/{id}` – Get user profile (admin or self)

## Example Request
```http
GET /api/vehicles?make=Rolls-Royce&price=over250 HTTP/1.1
Host: auraedition.com
Authorization: Bearer <token>
```

## Example Response
```json
{
  "vehicles": [
    { "id": 1, "title": "Phantom VIII", "price": 450000, ... },
    ...
  ]
}
```

## Error Handling
- Standard HTTP status codes
- JSON error messages

## Notes
- All endpoints will require HTTPS
- CORS headers for cross-origin requests 