(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-e7b650d8"],{"3c03":function(e,t,i){},5054:function(e,t,i){"use strict";i.r(t);var n=function(){var e=this,t=e._self._c;return t("div",{staticClass:"em-string__wrapper"},[t("div",{staticClass:"em-string",on:{click:function(t){return e.openEdit()}}},[e._v(e._s(e.fieldValue))]),e.showEdit?t("div",{directives:[{name:"click-outside",rawName:"v-click-outside",value:e.closeEdit,expression:"closeEdit"}],ref:"editString",staticClass:"em-string__edit",attrs:{contenteditable:""},on:{input:e.changeValue,keydown:function(t){return!t.type.indexOf("key")&&e._k(t.keyCode,"esc",27,t.key,["Esc","Escape"])?null:e.closeEdit.apply(null,arguments)}}}):e._e()])},s=[],c={props:["fieldValue","fieldSettings","mode","view"],data:function(){return{showEdit:!1}},methods:{changeValue:function(e){this.$emit("onChange",{value:e.target.innerText,settings:this.fieldSettings})},openEdit:function(){if("edit"!=this.mode)return!1;this.showEdit=!0,this.$nextTick((function(){this.$refs.editString.innerText=this.fieldValue;var e=document.createRange();e.selectNodeContents(this.$refs.editString),e.collapse(!1);var t=window.getSelection();t.removeAllRanges(),t.addRange(e)}))},closeEdit:function(){this.showEdit=!1},onEditString:function(e){this.fieldValue=e.target.innerText}}},o=c,a=(i("ace1"),i("2877")),d=Object(a["a"])(o,n,s,!1,null,null,null);t["default"]=d.exports},ace1:function(e,t,i){"use strict";i("3c03")}}]);
//# sourceMappingURL=chunk-e7b650d8.a3b85703.js.map