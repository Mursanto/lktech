<?php

// Check duplicates
$users = \App\Models\User::all();
$emails = [];
$duplicates = [];

foreach ($users as $user) {
    if (in_array($user->email, $emails)) {
        $duplicates[] = $user;
    } else {
        $emails[] = $user->email;
    }
}

foreach ($duplicates as $duplicate) {
    // Modify email to make it unique
    $duplicate->email = $duplicate->email . '.dup' . $duplicate->id;
    $duplicate->save();
    echo "Fixed duplicate email for user ID {$duplicate->id}\n";
}

// Create Demo Role
$demoRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Demo']);

// Create Demo User
$demoUser = \App\Models\User::updateOrCreate(
    ['email' => 'demo@lktech.com'],
    [
        'name' => 'Akun Demo',
        'password' => \Illuminate\Support\Facades\Hash::make('password'),
    ]
);

$demoUser->syncRoles(['Demo']);

echo "Demo account created successfully.\n";
