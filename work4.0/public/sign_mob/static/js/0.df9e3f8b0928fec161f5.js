webpackJsonp([0],{51:function(t,e,i){function n(t){i(63)}var o=i(15)(i(56),i(71),n,"data-v-8083bb46",null);t.exports=o.exports},56:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={data:function(){return{isShow:"sigin",navcolor:"#A7AABC",actcolor:"#fff",barrage:!1}},created:function(){var t=(window.location.href,new EF.URL(this.url));this.$store.state.vcode=t.get("vcode"),this.$store.state.openid=t.get("signin_openid")},mounted:function(){},computed:{prodecTree:function(){return this.$store.state.productData}},methods:{switched:function(t){this.isShow=t,"newsWall"==t&&this.$refs.newsChild.parentMsg(this.barrage)},barrageClick:function(){this.barrage=!this.barrage,this.$refs.newsChild.parentMsg(this.barrage)}},components:{"v-sigin":function(t){return i.e(4).then(function(){var e=[i(67)];t.apply(null,e)}.bind(this)).catch(i.oe)},"v-newsWall":function(t){return i.e(5).then(function(){var e=[i(66)];t.apply(null,e)}.bind(this)).catch(i.oe)},"v-vote":function(t){return i.e(3).then(function(){var e=[i(68)];t.apply(null,e)}.bind(this)).catch(i.oe)}}}},59:function(t,e,i){var n=i(50);e=t.exports=i(48)(!1),e.push([t.i,"#bg[data-v-8083bb46]{height:100%;background:url("+n(i(65))+") no-repeat;background-size:cover}.nav[data-v-8083bb46]{width:100%;height:1rem;position:fixed;bottom:0;left:0;z-index:100}.nav div[data-v-8083bb46]{float:left;width:25%;height:100%;line-height:1.3rem;border-right:1px solid hsla(0,0%,100%,.5);border-top:1px solid hsla(0,0%,100%,.5);text-align:center;background-color:hsla(0,0%,100%,.2)}.nav .act[data-v-8083bb46]{background-color:hsla(0,0%,100%,0);border-top:none}.content[data-v-8083bb46]{height:100%;padding-bottom:1rem}",""])},63:function(t,e,i){var n=i(59);"string"==typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);i(49)("5266b2b4",n,!0,{})},65:function(t,e,i){t.exports=i.p+"static/img/mbg1.d64324c.png"},71:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{attrs:{id:"bg"}},[this.$store.state.openid&&this.$store.state.openid?i("div",{staticClass:"nav"},[i("div",{class:"sigin"==t.isShow?"act":"",on:{click:function(e){t.switched("sigin")}}},[i("Icon",{attrs:{type:"location",size:"30",color:"sigin"==t.isShow?"#fff":"#A7AABC"}})],1),t._v(" "),i("div",{class:"newsWall"==t.isShow?"act":"text",on:{click:function(e){t.switched("newsWall")}}},[i("Icon",{attrs:{type:"chatbox-working",size:"30",color:"newsWall"==t.isShow?"#fff":"#A7AABC"}})],1),t._v(" "),i("div",{class:"luckDraw"==t.isShow?"act":"text",on:{click:function(e){t.switched("luckDraw")}}},[i("Icon",{attrs:{type:"social-dropbox",size:"30",color:"luckDraw"==t.isShow?"#fff":"#A7AABC"}})],1),t._v(" "),i("div",{class:"vote"==t.isShow?"act":"text",on:{click:function(e){t.switched("vote")}}},[i("Icon",{attrs:{type:"stats-bars",size:"30",color:"vote"==t.isShow?"#fff":"#A7AABC"}})],1)]):t._e(),t._v(" "),i("div",{staticClass:"content"},[i("v-sigin",{directives:[{name:"show",rawName:"v-show",value:"sigin"==t.isShow,expression:"isShow=='sigin'"}]}),t._v(" "),i("v-newsWall",{directives:[{name:"show",rawName:"v-show",value:"newsWall"==t.isShow,expression:"isShow=='newsWall'"}],ref:"newsChild"}),t._v(" "),"vote"==t.isShow?i("v-vote"):t._e()],1)])},staticRenderFns:[]}}});