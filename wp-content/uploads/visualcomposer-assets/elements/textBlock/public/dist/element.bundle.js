(window.vcvWebpackJsonp4x=window.vcvWebpackJsonp4x||[]).push([[0],{"./node_modules/raw-loader/index.js!./textBlock/editor.css":function(e,t){e.exports=".vce-text-block {\n  min-height: 1em;\n}\n"},"./textBlock/component.js":function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var o=u(n("./node_modules/babel-runtime/helpers/extends.js")),s=u(n("./node_modules/babel-runtime/core-js/object/get-prototype-of.js")),a=u(n("./node_modules/babel-runtime/helpers/classCallCheck.js")),l=u(n("./node_modules/babel-runtime/helpers/createClass.js")),i=u(n("./node_modules/babel-runtime/helpers/possibleConstructorReturn.js")),r=u(n("./node_modules/babel-runtime/helpers/inherits.js")),c=u(n("./node_modules/react/index.js"));function u(e){return e&&e.__esModule?e:{default:e}}var d=function(e){function t(){return(0,a.default)(this,t),(0,i.default)(this,(t.__proto__||(0,s.default)(t)).apply(this,arguments))}return(0,r.default)(t,e),(0,l.default)(t,[{key:"render",value:function(){var e=this.props,t=e.id,n=e.atts,s=e.editor,a=n.output,l=n.customClass,i=n.metaCustomId,r="vce-text-block",u={};"string"==typeof l&&l&&(r=r.concat(" "+l)),i&&(u.id=i);var d=this.applyDO("all");return c.default.createElement("div",(0,o.default)({className:r},s,u),c.default.createElement("div",(0,o.default)({className:"vce-text-block-wrapper vce",id:"el-"+t},d),a))}}]),t}(u(n("./node_modules/vc-cake/index.js")).default.getService("api").elementComponent);t.default=d},"./textBlock/index.js":function(e,t,n){"use strict";var o=a(n("./node_modules/vc-cake/index.js")),s=a(n("./textBlock/component.js"));function a(e){return e&&e.__esModule?e:{default:e}}n("./textBlock/migrationWPB.js"),(0,o.default.getService("cook").add)(n("./textBlock/settings.json"),function(e){e.add(s.default)},{css:!1,editorCss:n("./node_modules/raw-loader/index.js!./textBlock/editor.css")},"")},"./textBlock/migrationWPB.js":function(e,t,n){"use strict";var o=function(e){return e&&e.__esModule?e:{default:e}}(n("./node_modules/babel-runtime/core-js/object/assign.js")),s=n("./node_modules/vc-cake/index.js");var a=(0,s.getService)("cook"),l=(0,s.getStorage)("migration");l.on("migrateElement",function(e){if("vc_column_text"===e.tag){var t=e._generalElementAttributes;t.output=e._subInnerContent;var n=(0,o.default)({},t,{tag:"textBlock"}),s=a.get(n);l.trigger("add",s.toJS()),e._migrated=!0}})},"./textBlock/settings.json":function(e){e.exports={output:{type:"htmleditor",access:"public",value:"<h2>Typography is the art and technique</h2>\n<p>Typography is the art and technique of arranging type to make written language legible, readable and appealing when displayed. The arrangement of type involves selecting typefaces, point size, line length, line-spacing (leading), letter-spacing (tracking), and adjusting the space within letters pairs (kerning).</p>",options:{label:"Content",description:"Content for text block",inline:!0,skinToggle:"darkTextSkin"}},darkTextSkin:{type:"toggleSmall",access:"public",value:!1},designOptions:{type:"designOptions",access:"public",value:{},options:{label:"Design Options"}},editFormTab1:{type:"group",access:"protected",value:["output","metaCustomId","customClass"],options:{label:"General"}},metaEditFormTabs:{type:"group",access:"protected",value:["editFormTab1","designOptions"]},metaBackendLabels:{type:"group",access:"protected",value:[{value:["output"]}]},relatedTo:{type:"group",access:"protected",value:["General"]},metaOrder:{type:"number",access:"protected",value:3},customClass:{type:"string",access:"public",value:"",options:{label:"Extra class name",description:"Add an extra class name to the element and refer to it from Custom CSS option."}},assetsLibrary:{access:"public",type:"string",value:["animate"]},metaCustomId:{type:"customId",access:"public",value:"",options:{label:"Element ID",description:"Apply unique Id to element to link directly to it by using #your_id (for element id use lowercase input only)."}},tag:{access:"protected",type:"string",value:"textBlock"}}}},[["./textBlock/index.js"]]]);