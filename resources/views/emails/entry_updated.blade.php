<html>

<head>
    <title>Daily Entry Updated</title>
</head>

<body>
    <h1>Daily Entry Updated</h1>
    <p>Dear {{ $entry->user->name }},</p>
    <p>Your daily entry for {{ $entry->entry_date->format('F j, Y') }} has been updated.</p>
    <p><strong>Activities:</strong> {{ $entry->activities ?? 'N/A' }}</p>
    <p><strong>Mood:</strong> {{ $entry->mood ?? 'N/A' }}</p>
    <p><strong>Notes:</strong> {{ $entry->notes ?? 'N/A' }}</p>
    <p>Thank you for keeping your journal up to date.</p>
</body>

</html>
