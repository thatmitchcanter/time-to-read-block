const { registerBlockType } = wp.blocks;
const { __ } = wp.i18n;
const { InspectorControls, useBlockProps, PanelColorSettings } = wp.blockEditor;
const { PanelBody, ToggleControl, TextControl } = wp.components;

registerBlockType('ttrb/time-to-read', {
    title: __('Time to Read'),
    description: __('Display estimated reading time for a specific article'),
    category: 'widgets',
    usesContext: ['postId', 'postType'],
    attributes: {
        textColor: {
            type: 'string',
            default: null
        },
        backgroundColor: {
            type: 'string',
            default: null
        }
    },
    edit: function(props) {
        const { attributes, setAttributes } = props;
        const blockProps = useBlockProps();

        return (
            <>
                <InspectorControls>
                    <PanelColorSettings
                        title={__('Color Settings')}
                        colorSettings={[
                            {
                                value: attributes.textColor,
                                onChange: (value) => setAttributes({ textColor: value }),
                                label: __('Text Color'),
                                clearable: true
                            },
                            {
                                value: attributes.backgroundColor,
                                onChange: (value) => setAttributes({ backgroundColor: value }),
                                label: __('Background Color'),
                                clearable: true
                            }
                        ]}
                    />
                </InspectorControls>
                <div {...blockProps}>
                    <div 
                        className="ttrb-block"
                        style={{
                            color: attributes.textColor,
                            backgroundColor: attributes.backgroundColor,
                            padding: '10px',
                            borderRadius: '4px',
                            display: 'inline-flex',
                            alignItems: 'center',
                            gap: '8px'
                        }}
                    >
                        <span className="ttrb-text">
                            {__('Time to Read: XX')}
                        </span>
                    </div>
                </div>
            </>
        );
    },
    save: function() {
        return null; // Dynamic block, render callback on PHP side
    }
});