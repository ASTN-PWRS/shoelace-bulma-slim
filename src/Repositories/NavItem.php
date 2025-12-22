<?php

namespace App;

// $navItems = [
//     new NavItem('Home', '/home', true),
//     new NavItem('Documentation', '/docs'),
//     new NavItem('More', null, false, false, null, [
//         new NavItem('About', '/about'),
//         new NavItem('Jobs', '/jobs', true),
//         new NavItem('Contact', '/contact'),
//         new NavItem('Report an issue', '/report'),
//     ]),
// ];

// $navButtons = [
//     new NavItem('Sign up', '/signup', false, true, 'primary'),
//     new NavItem('Log in', '/login', false, true, 'default'),
// ];

class NavItem {
    public string $label;
    public ?string $href;
    public bool $active;
    public bool $isButton;
    public ?string $buttonVariant;
    public ?array $children; // NavItem[] for dropdowns

    public function __construct(
        string $label,
        ?string $href = null,
        bool $active = false,
        bool $isButton = false,
        ?string $buttonVariant = null,
        ?array $children = null
    ) {
        $this->label = $label;
        $this->href = $href;
        $this->active = $active;
        $this->isButton = $isButton;
        $this->buttonVariant = $buttonVariant;
        $this->children = $children;
    }
}
