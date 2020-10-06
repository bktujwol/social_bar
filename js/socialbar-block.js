
const { PanelBody } = wp.components;
const { InspectorControls } = wp.blockEditor;
const { useSelect } = wp.data;
const __ = wp.i18n.__;
const el = wp.element.createElement;
const useState = wp.element.useState;



const DisplayBar = props => {
    const postPermaLink = useSelect(select => select("core/editor").getPermalink());
    const options = props.options.attributes.socialOptions
        ;
    const [socialSharing, setSocialSharing] = useState(options);

    return el('section', { className: "sbgSocialbarMain" },
        el('ol', { className: 'sbgSocialbarChGrid' },
            options.map(x => {
                return el('li', {},
                    el('div', { className: 'sbgSocialbarChItem' },
                        el('div', { className: `sbgSocialbarChInfo sbgSocialbarChInfo${x.name}` },
                            el('div', { className: `sbgSocialbarChInfoFront sbgSocialbarCh${x.name}` }, ''),
                            el('div', { className: `sbgSocialbarChInfoBack sbgSocialbarChInfoBack${x.name}` }, ''),
                            el('p', { className: `sbgSocialbarTooltipP`, 'id': `sbgSocialbar${x.name}Tooltip` },
                                el('a', { className: `sbgSocialbar${x.name}Tooltip `, 'href': `${x.href}${postPermaLink}`, 'target': "_blank", 'title': `title="Share this page on ${x.name}"` }))
                        )));
            })

        ),

        el(InspectorControls, null,
            el(PanelBody, null,
                el('input', { 'type': "checkbox", 'id': "checkbox" },),
                el('lable', { 'label-for': 'checkbox' }, "Checkbox")
            )));

}



wp.blocks.registerBlockType('social-bar/socialbar-block', {
    title: __("Social Sharing", 'social-bar'),
    icon: 'share',
    description: __("Social sharing gutenberg block", "social-bar"),
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
                { name: "Pinterest", href: "http://pinterest.com/pin/create/link/?url=" }
            ]
        },
    },


    edit: props => el(DisplayBar, { options: props },),
    save: props => { console.log() }
});
