module.exports = {
  "services": [
    {
      "id": 1,
      "name": "Salle A",
      "type": "room",
      "slots": [
        "2025-10-20 09:00",
        "2025-10-20 10:00"
      ]
    },
    {
      "id": 2,
      "name": "Studio Photo",
      "type": "equipment",
      "slots": [
        "2025-10-20 14:00"
      ]
    }
  ],
  "users": [
    {
      "id": 1,
      "email": "admin@example.com",
      "role": "admin",
      "password": "$2y$10$JtZbEbfv9fHc1dFwhU8e3e1sLrZoQ5Fv1FmQiy9dfuh2O3ZpKJ9lG" 
      /* mot de passe: admin123 */
    },
    {
      "id": 2,
      "email": "user@example.com",
      "role": "user",
      "password": "$2y$10$zCJpFP2srm7cZYm5Oa7AmeV7Ck5V0Z/yb8hBKFpzQvCzwuE6byaeK"
      /* mot de passe: user123 */
    }
  ],
  "bookings": []
};
