<html>

<head>
    <title>New Daily Entry Created</title>
</head>

<body>
    <h1>New Daily Entry Created</h1>
    <p>Dear {{ $entry->user->name }},</p>
    <p>A new daily entry has been recorded on {{ $entry->entry_date->format('F j, Y') }}.</p>
    <p><strong>Activities:</strong> {{ $entry->activities ?? 'N/A' }}</p>
    <p><strong>Mood:</strong> {{ $entry->mood ?? 'N/A' }}</p>
    <p><strong>Notes:</strong> {{ $entry->notes ?? 'N/A' }}</p>
    <p>Thank you for using our Daily Journal System.</p>
</body>

</html>
