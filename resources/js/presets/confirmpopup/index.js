export default {
    root: {
        class: [
            // Shape
            'rounded-lg',
            'shadow-lg',
            'border-0',

            // Positioning
            'z-40 transform origin-center',
            'mt-3 absolute left-0 top-0',
            '[&[data-p-confirmpopup-flipped="true"]]:mb-3 [&[data-p-confirmpopup-flipped="true"]]:-mt-3',

            // Color
            'dark:border',
            'dark:border-surface-700',
            'bg-surface-0 dark:bg-surface-800',
            'text-surface-700 dark:text-surface-0/80',

            //  Arrow
            'before:absolute before:w-0 before:-top-3 before:h-0 before:border-transparent before:border-solid before:ml-[10px] before:border-x-[10px] before:border-b-[10px] before:border-t-0 before:border-b-surface-200 dark:before:border-b-surface-700',
            'after:absolute after:w-0 after:-top-[0.54rem] after:left-[4px] after:h-0 after:border-transparent after:border-solid after:ml-[8px] after:border-x-[8px] after:border-b-[8px] after:border-t-0 after:border-b-surface-0 dark:after:border-b-surface-800',

            // Flipped: Arrow
            '[&[data-p-confirmpopup-flipped="true"]]:before:-bottom-3 [&[data-p-confirmpopup-flipped="true"]]:before:top-auto [&[data-p-confirmpopup-flipped="true"]]:before:border-b-0 [&[data-p-confirmpopup-flipped="true"]]:before:border-t-[10px] [&[data-p-confirmpopup-flipped="true"]]:before:border-t-surface-200 dark:[&[data-p-confirmpopup-flipped="true"]]:before:border-t-surface-700',
            '[&[data-p-confirmpopup-flipped="true"]]:after:-bottom-[0.54rem] [&[data-p-confirmpopup-flipped="true"]]:after:top-auto [&[data-p-confirmpopup-flipped="true"]]:after:border-b-0 [&[data-p-confirmpopup-flipped="true"]]:after:border-t-[8px] [&[data-p-confirmpopup-flipped="true"]]:after:border-t-surface-0 dark:[&[data-p-confirmpopup-flipped="true"]]:after:border-t-surface-800',
        ],
    },
    content: {
        class: 'p-5 items-center flex',
    },
    icon: {
        class: 'text-2xl mr-4',
    },
    footer: {
        class: [
            // Flexbox and Alignment
            'flex items-center justify-end',
            'shrink-0',
            'text-right',
            'gap-2',

            // Spacing
            'px-6',
            'pb-6',

            // Shape
            'border-t-0',
            'rounded-b-lg',

            // Colors
            'bg-surface-0 dark:bg-surface-800',
            'text-surface-700 dark:text-surface-0/80',
        ],
    },
    transition: {
        enterFromClass: 'opacity-0 scale-y-[0.8]',
        enterActiveClass: 'transition-[transform,opacity] duration-[120ms] ease-[cubic-bezier(0,0,0.2,1)]',
        leaveActiveClass: 'transition-opacity duration-100 ease-linear',
        leaveToClass: 'opacity-0',
    },
}
