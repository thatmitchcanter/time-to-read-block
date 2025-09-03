const { registerBlockType } = wp.blocks;
const { __ } = wp.i18n;
const { InspectorControls, useBlockProps } = wp.blockEditor;
const { PanelBody, TextControl } = wp.components;

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
            fontStyle: true,
            lineHeight: true,
            letterSpacing: true,
            textTransform: true,
            textDecoration: true
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
    attributes: {
        wordsPerMinute: {
            type: 'number',
            default: 275
        }
    },
    edit: function(props) {
        const { attributes, setAttributes } = props;
        const blockProps = useBlockProps();

        return (
            <>
                <InspectorControls>
                    <PanelBody title={__('Reading Settings')} initialOpen={true}>
                        <TextControl
                            label={__('Words per Minute')}
                            value={attributes.wordsPerMinute}
                            onChange={(value) => setAttributes({ wordsPerMinute: parseInt(value) || 275 })}
                            help={__('Average reading speed (default: 275 WPM)')}
                            type="number"
                        />
                    </PanelBody>
                </InspectorControls>
                <div {...blockProps}>
                    <span className="ttrb-text">
                        {__('Time to Read: XX')}
                    </span>
                </div>
            </>
        );
    },
    save: function() {
        return null; // Dynamic block, render callback on PHP side
    }
});