export default {
    root: ({ props }) => ({
        class: [
            'inline-flex select-none align-bottom outline-transparent',
            'rounded-md [&>button]:rounded-none',
            '[&>button:first-child]:border-r-none [&>button:first-child]:rounded-r-none [&>button:first-child]:rounded-tl-md [&>button:first-child]:rounded-bl-md',
            '[&>button:last-child]:border-l-none [&>button:first-child]:rounded-l-none [&>button:last-child]:rounded-tr-md [&>button:last-child]:rounded-br-md',

            // Invalid State
            {
                '[&>button]:border [&>button]:border-red-500 [&>button]:dark:border-red-400': props.invalid,
            },
        ],
    }),
}
