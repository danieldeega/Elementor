(function (plugins, editPost, element, components, data, compose) {
  const el = element.createElement;

  const { Fragment } = element;
  const { registerPlugin } = plugins;
  const {
    PluginSidebar,
    PluginSidebarMoreMenuItem,
    PluginDocumentSettingPanel,
  } = editPost;
  const {
    PanelBody,
    TextControl,
    TextareaControl,
    RangeControl,
    ToggleControl,
  } = components;
  const { withSelect, withDispatch } = data;

  const MetaTextControl = compose.compose(
    withDispatch(function (dispatch, props) {
      return {
        setMetaValue: function (metaValue) {
          dispatch("core/editor").editPost({
            meta: { [props.metaKey]: metaValue },
          });
        },
      };
    }),
    withSelect(function (select, props) {
      return {
        metaValue:
          select("core/editor").getEditedPostAttribute("meta")[props.metaKey],
      };
    })
  )(function (props) {
    return el(TextControl, {
      label: props.title,
      value: props.metaValue,
      onChange: function (content) {
        props.setMetaValue(content);
      },
    });
  });
  const MetaRangeControl = compose.compose(
    withDispatch(function (dispatch, props) {
      return {
        setMetaValue: function (metaValue) {
          dispatch("core/editor").editPost({
            meta: { [props.metaKey]: metaValue },
          });
        },
      };
    }),
    withSelect(function (select, props) {
      return {
        metaValue:
          select("core/editor").getEditedPostAttribute("meta")[props.metaKey],
      };
    })
  )(function (props) {
    return el(RangeControl, {
      label: props.title,
      value: props.metaValue,
      step: 0.01,
      min: 1,
      max: 200,
      onChange: function (content) {
        props.setMetaValue(content);
      },
    });
  });
  const MetaTextareaControl = compose.compose(
    withDispatch(function (dispatch, props) {
      return {
        setMetaValue: function (metaValue) {
          dispatch("core/editor").editPost({
            meta: { [props.metaKey]: metaValue },
          });
        },
      };
    }),
    withSelect(function (select, props) {
      var meta = select("core/editor").getEditedPostAttribute("meta")[
        props.metaKey
      ]
        ? select("core/editor").getEditedPostAttribute("meta")[props.metaKey]
        : "";
      return {
        metaValue: meta,
      };
    })
  )(function (props) {
    return el(TextareaControl, {
      label: props.title,
      value: props.metaValue,
      onChange: function (content) {
        props.setMetaValue(content);
      },
    });
  });
  const MetaToggleControl = compose.compose(
    withDispatch(function (dispatch, props) {
      return {
        setMetaValue: function (metaValue) {
          dispatch("core/editor").editPost({
            meta: { [props.metaKey]: metaValue },
          });
        },
      };
    }),
    withSelect(function (select, props) {
      return {
        metaValue:
          select("core/editor").getEditedPostAttribute("meta")[props.metaKey],
      };
    })
  )(function (props) {
    return el(ToggleControl, {
      label: props.title,
      checked: props.metaValue,
      onChange: function (content) {
        props.setMetaValue(content);
      },
    });
  });

  registerPlugin("twentytwentychild-products", {
    render: function () {
      return el(
        Fragment,
        {},
        el(
          PluginDocumentSettingPanel,
          {
            name: "twentytwentychild-products",
            title: "Product Settings",
          },

          el(MetaTextareaControl, {
            metaKey: "twentytwentychild_products_description",
            title: "Description",
          }),
          el(MetaRangeControl, {
            metaKey: "twentytwentychild_products_price",
            title: "Price",
          }),
          el(MetaToggleControl, {
            metaKey: "twentytwentychild_products_is_on_sale",
            title: "On Sale ?",
          }),
          el(MetaRangeControl, {
            metaKey: "twentytwentychild_products_sale_price",
            title: "Sale Price",
          }),
          el(MetaTextControl, {
            metaKey: "twentytwentychild_products_video",
            title: "Url of YouTube video",
          })
        )
      );
    },
  });
})(
  window.wp.plugins,
  window.wp.editPost,
  window.wp.element,
  window.wp.components,
  window.wp.data,
  window.wp.compose
);
