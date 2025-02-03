<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmation</title>
</head>
<body>
    <h2>Booking Confirmation</h2>
    <p>Hello {{ $customerName }},</p>
    <p>Your booking has been successfully created. Here are the details:</p>
    <ul>
        <li><strong>Tour Name:</strong> {{ $tourName }}</li>
        <li><strong>Hotel Name:</strong> {{ $hotelName }}</li>
        <li><strong>Booking Date:</strong> {{ $bookingDate }}</li>
        <li><strong>Number of People:</strong> {{ $numberOfPeople }}</li>
    </ul>
</body>
</html>
