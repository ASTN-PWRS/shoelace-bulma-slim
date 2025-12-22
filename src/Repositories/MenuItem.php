<?php
namespace App;

// $menuItems = [
//     new MenuItem('Undo', 'undo'),
//     new MenuItem('Redo', 'redo'),
//     new MenuItem('', null, false, true), // divider
//     new MenuItem('Cut', 'cut'),
//     new MenuItem('Copy', 'copy'),
//     new MenuItem('Paste', 'paste'),
//     new MenuItem('', null, false, true), // divider
//     new MenuItem('Find', null, false, false, null, null, null, null, [
//         new MenuItem('Find…', 'find'),
//         new MenuItem('Find Next', 'find-previous'),
//         new MenuItem('Find Previous', 'find-next'),
//     ]),
//     new MenuItem('Transformations', null, false, false, null, null, null, null, [
//         new MenuItem('Make uppercase', 'uppercase'),
//         new MenuItem('Make lowercase', 'lowercase'),
//         new MenuItem('Capitalize', 'capitalize'),
//     ]),
// ];

class MenuItem {
    public string $label;
    public ?string $value;
    public bool $disabled;
    public bool $divider;
    public ?string $prefixIcon;
    public ?string $suffixIcon;
    public ?string $href;
    public ?string $onClick;
    /** @var MenuItem[]|null */
    public ?array $children;

    public function __construct(
        string $label,
        ?string $value = null,
        bool $disabled = false,
        bool $divider = false,
        ?string $prefixIcon = null,
        ?string $suffixIcon = null,
        ?string $href = null,
        ?string $onClick = null,
        ?array $children = null
    ) {
        $this->label = $label;
        $this->value = $value;
        $this->disabled = $disabled;
        $this->divider = $divider;
        $this->prefixIcon = $prefixIcon;
        $this->suffixIcon = $suffixIcon;
        $this->href = $href;
        $this->onClick = $onClick;
        $this->children = $children;
    }
}
