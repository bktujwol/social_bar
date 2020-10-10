
const { CheckboxControl, PanelBody } = wp.components;
const { InspectorControls } = wp.blockEditor;
const { useSelect } = wp.data;
const { __ } = wp.i18n;
const el = wp.element.createElement;
const { registerBlockType } = wp.blocks;

registerBlockType('social-bar/socialbar-block', {
    title: __("Social Sharing", 'social-bar'),
    icon: 'share',
    description: __("Social sharing block", "social-bar"),
    category: 'common',
    keywords: [__('Social Bar', 'social-bar'), __('Social Sharing', 'social-bar')],
    example: {},
    attributes: {
        socialOptions: {
            type: 'array',
            default: [
                { name: 'Facebook', href: 'https://www.facebook.com/sharer/sharer.php?u=' },
                { name: "Twitter", href: 'http://twitter.com/share?url=' },
                { name: 'Linkedin', href: 'http://www.linkedin.com/cws/share?url=' },
                { name: "Pinterest", href: "http://pinterest.com/pin/create/link/?url=" },
                { name: "Reddit", href: "http://www.reddit.com/submit?url=" }
            ]
        },
        socialOptionsInput: {
            type: 'array',
            default: [
                { name: 'Facebook', href: 'https://www.facebook.com/sharer/sharer.php?u=', checked: true },
                { name: "Twitter", href: 'http://twitter.com/share?url=', checked: true },
                { name: 'Linkedin', href: 'http://www.linkedin.com/cws/share?url=', checked: true },
                { name: "Pinterest", href: "http://pinterest.com/pin/create/link/?url=", checked: true },
                { name: "Reddit", href: "http://www.reddit.com/submit?url=", checked: true }
            ]
        },
        postPermalink: {
            type: 'string',
            default: ''
        }
    },


    edit: props => {
        const postPermaLink = useSelect(select => select("core/editor").getPermalink());
        props.setAttributes({ postPermalink: postPermaLink })

        return el('div', null, el('section', { className: "sbgSocialbarMain" },
            el('ol', { className: 'sbgSocialbarChGrid' },
                props.attributes.socialOptions.map(x => {
                    return el('li', null,
                        el('div', { className: 'sbgSocialbarChItem' },
                            el('div', { className: `sbgSocialbarChInfo sbgSocialbarChInfo${x.name}` },
                                el('div', { className: `sbgSocialbarChInfoFront sbgSocialbarCh${x.name}` }, ''),
                                el('div', { className: `sbgSocialbarChInfoBack sbgSocialbarChInfoBack${x.name}` }, ''),
                                el('p', { className: `sbgSocialbarTooltipP`, id: `sbgSocialbar${x.name}Tooltip` },
                                    el('a', { className: `sbgSocialbar${x.name}Tooltip`, href: `${x.href}${props.attributes.postPermalink}`, target: "_blank", title: `Share this page on ${x.name}` }, ''))
                            )));
                })

            ),
            el(InspectorControls, null,
                el(PanelBody, null,
                    props.attributes.socialOptionsInput.map((x, i) => el('div', { 'id': 'sbg-social-sharing' },
                        el(CheckboxControl, {
                            name: x.name,
                            label: x.name,
                            checked: x.checked,
                            id: `${x.name}-sbg`,
                            onChange: checked => {
                                props.setAttributes({ socialOptions: props.attributes.socialOptionsInput.filter(x => true === document.querySelector(`#${x.name}-sbg`).checked) });
                                props.setAttributes({ socialOptionsInput: props.attributes.socialOptionsInput.map(x => { return { name: x.name, href: x.href, checked: document.querySelector(`#${x.name}-sbg`).checked } }) });
                            },
                        }),
                    )
                    )

                ))));
    },
    save: props => {
        return (
            el('div', null, el('section', { className: "sbgfSocialbarMain" },
                el('ol', { className: 'sbgfSocialbarChGrid' },
                    props.attributes.socialOptions.map(x => {
                        return el('li', null,
                            el('div', { className: 'sbgfSocialbarChItem' },
                                el('div', { className: `sbgfSocialbarChInfo sbgfSocialbarChInfo${x.name}` },
                                    el('div', { className: `sbgfSocialbarChInfoFront sbgfSocialbarCh${x.name}` }, ''),
                                    el('div', { className: `sbgfSocialbarChInfoBack sbgfSocialbarChInfoBack${x.name}` }, ''),
                                    el('p', { className: `sbgfSocialbarTooltipP`, id: `sbgfSocialbar${x.name}Tooltip` },
                                        el('a', { className: `sbgfSocialbar${x.name}Tooltip`, href: `${x.href}${props.attributes.postPermalink}`, target: "_blank", title: `Share this page on ${x.name}`, rel: 'noopener noreferrer' }, ''))
                                )));
                    })

                )))

        );
    }
});
