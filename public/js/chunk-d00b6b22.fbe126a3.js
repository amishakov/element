(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-d00b6b22"],{"0db4":function(e,t,s){"use strict";s("b29f")},b29f:function(e,t,s){},efa1:function(e,t,s){"use strict";s.r(t);var a=function(){var e=this,t=e._self._c;return t("div",{staticClass:"update-wrapper"},[t("div",{staticClass:"update-head"},[t("div",{staticClass:"update-head__burger"},[t("MobileBurger")],1),t("div",{staticClass:"update-head-name"},[t("div",{staticClass:"update-icon-wrapper"},[e._v(" ⚙️ ")]),t("div",{staticClass:"update-name-wrapper"},[t("div",{staticClass:"update-head-label"},[e._v(e._s(e.$t("update")))]),t("div",{staticClass:"update-head-descr"},[e._v(e._s(e.$t("pages.update.check_and_update_element")))])])])]),t("div",{staticClass:"update-content"},[t("div",{staticClass:"update-version"},[e._v("\n\t\t\t"+e._s(e.$t("pages.update.current_version"))+" "),t("em",[e._v(e._s(e.currentVersion))]),e.showLatestIsInstalled&&!e.showLoader?t("div",[e._v(e._s(e.$t("pages.update.you_have_the_latest_version")))]):e._e()]),e.successUpdate?[t("div",{staticClass:"update-success"},[e._v(e._s(e.$t("pages.update.system_has_been_updated_successfully")))])]:e._e(),e.showLoader?t("Loader",{staticClass:"update__loader"}):e._e(),e.successUpdate?e._e():t("div",{staticClass:"update-buttons"},[t("button",{staticClass:"el-gbtn",on:{click:function(t){return e.checkVersion()}}},[e._v(e._s(e.$t("pages.update.check_version")))]),e.canUpdate?t("button",{staticClass:"el-btn",on:{click:function(t){return e.update()}}},[e._v(e._s(e.$t("pages.update.update_to"))+" "+e._s(e.newVersion))]):e._e()])],2)])},n=[],r=(s("96cf"),s("3b8d")),i=s("d716"),u=s("25bd"),c={components:{Loader:i["a"],MobileBurger:u["a"]},data:function(){return{currentVersion:"",canUpdate:!1,newVersion:"",showLatestIsInstalled:!1,successUpdate:!1,showLoader:!1}},methods:{checkVersion:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(){var t;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return this.showLoader=!0,e.next=3,this.$axios.get("/settings/checkVersion/");case 3:if(t=e.sent,this.showLoader=!1,"undefined"!=typeof t.data.success){e.next=7;break}return e.abrupt("return",this.ElMessage.error(this.$t("elMessages.something_goes_wrong")));case 7:1==t.data.result?(this.canUpdate=!0,this.newVersion=t.data.new_version):this.showLatestIsInstalled=!0;case 8:case"end":return e.stop()}}),e,this)})));function t(){return e.apply(this,arguments)}return t}(),update:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(){var t;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return this.showLoader=!0,e.next=3,this.$axios.get("/settings/update/");case 3:t=e.sent,this.showLoader=!1,"undefined"!=typeof t.data.success&&t.data.success&&(this.successUpdate=!0);case 6:case"end":return e.stop()}}),e,this)})));function t(){return e.apply(this,arguments)}return t}()},mounted:function(){var e=Object(r["a"])(regeneratorRuntime.mark((function e(){var t;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,this.$axios.get("/settings/getCurrentVersion/");case 2:t=e.sent,"undefined"!=typeof t.data.success&&t.data.success&&(this.currentVersion=t.data.version);case 4:case"end":return e.stop()}}),e,this)})));function t(){return e.apply(this,arguments)}return t}()},d=c,o=(s("0db4"),s("2877")),p=Object(o["a"])(d,a,n,!1,null,null,null);t["default"]=p.exports}}]);
//# sourceMappingURL=chunk-d00b6b22.fbe126a3.js.map