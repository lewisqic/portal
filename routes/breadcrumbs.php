<?php

/**
 * ADMIN breadcrumbs
 */

// dashboard
\Breadcrumbs::register('admin', function($breadcrumbs)
{
    $breadcrumbs->push('Dashboard', url('admin'));
});

// profile
\Breadcrumbs::register('admin/profile', function($breadcrumbs)
{
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Profile', url('admin/profile'));
});

// settings
\Breadcrumbs::register('admin/settings', function($breadcrumbs)
{
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Settings', url('admin/settings'));
});

// members
\Breadcrumbs::register('admin/members', function($breadcrumbs)
{
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Members', url('admin/members'));
});
\Breadcrumbs::register('admin/members/create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin/members');
    $breadcrumbs->push('Create', url('admin/members/create'));
});
\Breadcrumbs::register('admin/members/show', function($breadcrumbs, $user)
{
    $breadcrumbs->parent('admin/members');
    $breadcrumbs->push($user->name, url('admin/members/' . $user->id));
});
\Breadcrumbs::register('admin/members/edit', function($breadcrumbs, $user)
{
    $breadcrumbs->parent('admin/members/show', $user);
    $breadcrumbs->push('Edit', url('admin/members/edit/' . $user->id));
});

// member roles
\Breadcrumbs::register('admin/members/roles', function($breadcrumbs)
{
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Roles', url('admin/members/roles'));
});
\Breadcrumbs::register('admin/members/roles/create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin/members/roles');
    $breadcrumbs->push('Create', url('admin/members/roles/create'));
});
\Breadcrumbs::register('admin/members/roles/show', function($breadcrumbs, $role)
{
    $breadcrumbs->parent('admin/members/roles');
    $breadcrumbs->push($role->name, url('admin/members/roles/' . $role->id));
});
\Breadcrumbs::register('admin/members/roles/edit', function($breadcrumbs, $role)
{
    $breadcrumbs->parent('admin/members/roles/show', $role);
    $breadcrumbs->push('Edit', url('admin/members/roles/edit/' . $role->id));
});

// administrators
\Breadcrumbs::register('admin/administrators', function($breadcrumbs)
{
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Administrators', url('admin/administrators'));
});
\Breadcrumbs::register('admin/administrators/create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin/administrators');
    $breadcrumbs->push('Create', url('admin/administrators/create'));
});
\Breadcrumbs::register('admin/administrators/show', function($breadcrumbs, $user)
{
    $breadcrumbs->parent('admin/administrators');
    $breadcrumbs->push($user->name, url('admin/administrators/' . $user->id));
});
\Breadcrumbs::register('admin/administrators/edit', function($breadcrumbs, $user)
{
    $breadcrumbs->parent('admin/administrators/show', $user);
    $breadcrumbs->push('Edit', url('admin/administrators/edit/' . $user->id));
});

// administrator roles
\Breadcrumbs::register('admin/roles', function($breadcrumbs)
{
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Roles', url('admin/roles'));
});
\Breadcrumbs::register('admin/roles/create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin/roles');
    $breadcrumbs->push('Create', url('admin/roles/create'));
});
\Breadcrumbs::register('admin/roles/show', function($breadcrumbs, $role)
{
    $breadcrumbs->parent('admin/roles');
    $breadcrumbs->push($role->name, url('admin/roles/' . $role->id));
});
\Breadcrumbs::register('admin/roles/edit', function($breadcrumbs, $role)
{
    $breadcrumbs->parent('admin/roles/show', $role);
    $breadcrumbs->push('Edit', url('admin/roles/edit/' . $role->id));
});

// files
\Breadcrumbs::register('admin/files', function($breadcrumbs)
{
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Files', url('admin/files'));
});
\Breadcrumbs::register('admin/files/create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin/files');
    $breadcrumbs->push('Create', url('admin/files/create'));
});
\Breadcrumbs::register('admin/files/show', function($breadcrumbs, $file)
{
    $breadcrumbs->parent('admin/files');
    $breadcrumbs->push($file->name, url('admin/files/' . $file->id));
});
\Breadcrumbs::register('admin/files/edit', function($breadcrumbs, $file)
{
    $breadcrumbs->parent('admin/files/show', $file);
    $breadcrumbs->push('Edit', url('admin/files/edit/' . $file->id));
});

// file-categories
\Breadcrumbs::register('admin/file-categories', function($breadcrumbs)
{
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('File Categories', url('admin/file-categories'));
});
\Breadcrumbs::register('admin/file-categories/create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin/file-categories');
    $breadcrumbs->push('Create', url('admin/file-categories/create'));
});
\Breadcrumbs::register('admin/file-categories/show', function($breadcrumbs, $file)
{
    $breadcrumbs->parent('admin/file-categories');
    $breadcrumbs->push($file->name, url('admin/file-categories/' . $file->id));
});
\Breadcrumbs::register('admin/file-categories/edit', function($breadcrumbs, $file)
{
    $breadcrumbs->parent('admin/file-categories/show', $file);
    $breadcrumbs->push('Edit', url('admin/file-categories/edit/' . $file->id));
});

// activity-logs
\Breadcrumbs::register('admin/activity-logs', function($breadcrumbs)
{
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Activity Logs', url('admin/activity-logs'));
});
\Breadcrumbs::register('admin/activity-logs/create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin/activity-logs');
    $breadcrumbs->push('Create', url('admin/activity-logs/create'));
});
\Breadcrumbs::register('admin/activity-logs/show', function($breadcrumbs, $file)
{
    $breadcrumbs->parent('admin/activity-logs');
    $breadcrumbs->push($file->name, url('admin/activity-logs/' . $file->id));
});
\Breadcrumbs::register('admin/activity-logs/edit', function($breadcrumbs, $file)
{
    $breadcrumbs->parent('admin/activity-logs/show', $file);
    $breadcrumbs->push('Edit', url('admin/activity-logs/edit/' . $file->id));
});



/**
 * ACCOUNT breadcrumbs
 */

// dashboard
\Breadcrumbs::register('account', function($breadcrumbs)
{
    $breadcrumbs->push('Dashboard', url('account'));
});

// setup wizard
\Breadcrumbs::register('account/setup', function($breadcrumbs)
{
    $breadcrumbs->push('Setup Wizard', url('account/setup'));
});

// activation
\Breadcrumbs::register('account/activate', function($breadcrumbs)
{
    $breadcrumbs->parent('account');
    $breadcrumbs->push('Activate Account', url('account/activate'));
});

// verify
\Breadcrumbs::register('account/verify', function($breadcrumbs)
{
    $breadcrumbs->parent('account');
    $breadcrumbs->push('Verify Account', url('account/verify'));
});

// profile
\Breadcrumbs::register('account/profile', function($breadcrumbs)
{
    $breadcrumbs->parent('account');
    $breadcrumbs->push('Profile', url('account/profile'));
});

// billing
\Breadcrumbs::register('account/billing/subscription', function($breadcrumbs)
{
    $breadcrumbs->parent('account');
    $breadcrumbs->push('My Subscription', url('account/billing/subscription'));
});
\Breadcrumbs::register('account/billing/upgrade', function($breadcrumbs)
{
    $breadcrumbs->parent('account');
    $breadcrumbs->push('Complete Subscription', url('account/billing/upgrade'));
});
\Breadcrumbs::register('account/billing/payment-methods', function($breadcrumbs)
{
    $breadcrumbs->parent('account');
    $breadcrumbs->push('Payment Methods', url('account/billing/payment-methods'));
});
\Breadcrumbs::register('account/billing/history', function($breadcrumbs)
{
    $breadcrumbs->parent('account');
    $breadcrumbs->push('Billing History', url('account/billing/history'));
});
\Breadcrumbs::register('account/billing/change-plan', function($breadcrumbs)
{
    $breadcrumbs->parent('account/billing/subscription');
    $breadcrumbs->push('Change Subscription Plan', url('account/billing/change-plan'));
});

// settings
\Breadcrumbs::register('account/settings', function($breadcrumbs)
{
    $breadcrumbs->parent('account');
    $breadcrumbs->push('Settings', url('account/settings'));
});

// users
\Breadcrumbs::register('account/users', function($breadcrumbs)
{
    $breadcrumbs->parent('account');
    $breadcrumbs->push('Users', url('account/users'));
});
\Breadcrumbs::register('account/users/create', function($breadcrumbs)
{
    $breadcrumbs->parent('account/users');
    $breadcrumbs->push('Create', url('account/users/create'));
});
\Breadcrumbs::register('account/users/show', function($breadcrumbs, $user)
{
    $breadcrumbs->parent('account/users');
    $breadcrumbs->push($user->name, url('account/users/' . $user->id));
});
\Breadcrumbs::register('account/users/edit', function($breadcrumbs, $user)
{
    $breadcrumbs->parent('account/users/show', $user);
    $breadcrumbs->push('Edit', url('account/users/edit/' . $user->id));
});

// user roles
\Breadcrumbs::register('account/roles', function($breadcrumbs)
{
    $breadcrumbs->parent('account');
    $breadcrumbs->push('User Roles', url('account/roles'));
});
\Breadcrumbs::register('account/roles/create', function($breadcrumbs)
{
    $breadcrumbs->parent('account/roles');
    $breadcrumbs->push('Create', url('account/roles/create'));
});
\Breadcrumbs::register('account/roles/show', function($breadcrumbs, $role)
{
    $breadcrumbs->parent('account/roles');
    $breadcrumbs->push($role->name, url('account/roles/' . $role->id));
});
\Breadcrumbs::register('account/roles/edit', function($breadcrumbs, $role)
{
    $breadcrumbs->parent('account/roles/show', $role);
    $breadcrumbs->push('Edit', url('account/roles/edit/' . $role->id));
});

// forms
\Breadcrumbs::register('account/forms', function($breadcrumbs)
{
    $breadcrumbs->parent('account');
    $breadcrumbs->push('Forms', url('account/forms'));
});
\Breadcrumbs::register('account/forms/create', function($breadcrumbs)
{
    $breadcrumbs->parent('account/forms');
    $breadcrumbs->push('Create', url('account/forms/create'));
});
\Breadcrumbs::register('account/forms/show', function($breadcrumbs, $form)
{
    $breadcrumbs->parent('account/forms');
    $breadcrumbs->push($form->title, url('account/forms/' . $form->id));
});
\Breadcrumbs::register('account/forms/edit', function($breadcrumbs, $form)
{
    $breadcrumbs->parent('account/forms/show', $form);
    $breadcrumbs->push('Edit', url('account/forms/edit/' . $form->id));
});

// themes
\Breadcrumbs::register('account/themes', function($breadcrumbs)
{
    $breadcrumbs->parent('account');
    $breadcrumbs->push('Themes', url('account/themes'));
});
\Breadcrumbs::register('account/themes/create', function($breadcrumbs)
{
    $breadcrumbs->parent('account/themes');
    $breadcrumbs->push('Create', url('account/themes/create'));
});
\Breadcrumbs::register('account/themes/show', function($breadcrumbs, $theme)
{
    $breadcrumbs->parent('account/themes');
    $breadcrumbs->push($theme->name, url('account/themes/' . $theme->id));
});
\Breadcrumbs::register('account/themes/edit', function($breadcrumbs, $theme)
{
    $breadcrumbs->parent('account/themes/show', $theme);
    $breadcrumbs->push('Edit', url('account/themes/edit/' . $theme->id));
});