const { registerBlockType } = wp.blocks;
const { __ } = wp.i18n;
const { useBlockProps } = wp.blockEditor;

registerBlockType('ttrb/time-to-read', {
    title: __('Time to Read'),
    description: __('Display estimated reading time for a specific article'),
    icon: 'clock',
    category: 'widgets',
    usesContext: ['postId', 'postType'],
    supports: {
        color: {
            text: true,
            background: true
        },
        typography: {
            fontSize: true,
            fontFamily: true,
            fontWeight: true,
            lineHeight: true,
            letterSpacing: true,
            textTransform: true
        },
        spacing: {
            padding: true,
            margin: true
        },
        dimensions: {
            minHeight: true
        },
        __experimentalBorder: {
            color: true,
            radius: true,
            style: true,
            width: true
        }
    },
    attributes: {},
    edit: function(props) {
        const blockProps = useBlockProps();

        return (
            <div {...blockProps}>
                <span className="ttrb-text">
                    {__('Time to Read: XX')}
                </span>
            </div>
        );
    },
    save: function() {
        return null; // Dynamic block, render callback on PHP side
    }
});