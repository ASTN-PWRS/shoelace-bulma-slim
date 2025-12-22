<?php
namespace App;

// use App\MenuItem;
// use App\DropdownMenu;

// $dropdown = new DropDownMenu('Edit', [
//     new MenuItem('Cut', 'cut'),
//     new MenuItem('Copy', 'copy'),
//     new MenuItem('Paste', 'paste'),
// ]);

// $navItems = [
//     new NavItem('Home', '/home', true),
//     new NavItem('Documentation', '/docs'),
//     new DropdownMenu('More', [
//         new MenuItem('About', 'about'),
//         new MenuItem('Jobs', 'jobs', true),
//         new MenuItem('Contact', 'contact'),
//         new MenuItem('Report an issue', 'report', false, true),
//     ]),
// ];

// $navButtons = [
//     new NavItem('Sign up', '/signup', false, true, 'primary'),
//     new NavItem('Log in', '/login', false, true, 'default'),
// ];


class DropDownMenu {
    public string $label;

    /** @var MenuItem[] */
    public array $items;

    public string $triggerIcon;

    public function __construct(string $label, array $items, string $triggerIcon = 'caret') {
        $this->label = $label;
        $this->items = $items;
        $this->triggerIcon = $triggerIcon;
    }
}