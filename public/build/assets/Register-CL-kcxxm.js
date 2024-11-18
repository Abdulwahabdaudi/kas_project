import{z as g,r as w,j as v,o as p,b as x,a as r,x as V,A as y,T as b,c as k,w as u,f as o,n as s,Z as h,g as c,p as q,q as U,l as $}from"./app-BWj68EOb.js";import{_ as P}from"./GuestLayout-eZ2qlJXk.js";import{_ as i,a as d,b as n}from"./TextInput-BXYdeWuW.js";import{P as B}from"./PrimaryButton-MBBQCkGt.js";import"./ApplicationLogo-G96j6Wgk.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const M={class:"flex w-full relative"},N={class:"relative w-full"},A={__name:"PhoneInput",props:{modelValue:{type:String,required:!0},modelModifiers:{}},emits:["update:modelValue"],setup(f,{expose:e}){const m=g(f,"modelValue"),t=w(null);return v(()=>{t.value.hasAttribute("autofocus")&&t.value.focus()}),e({focus:()=>t.value.focus()}),(l,a)=>(p(),x("div",M,[r("div",N,[V(r("input",{class:"w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm","onUpdate:modelValue":a[0]||(a[0]=_=>m.value=_),ref_key:"input",ref:t,placeholder:"07xxxxxxxx",required:""},null,512),[[y,m.value]])])]))}},C={class:"mt-4"},R={class:"mt-4"},T={class:"mt-4"},j={class:"mt-4"},z={class:"mt-4"},E={class:"flex items-center justify-end mt-4"},G={__name:"Register",setup(f){const e=b({first_name:"",last_name:"",email:"",phone:"",password:"",password_confirmation:""}),m=()=>{e.post(route("register"),{onFinish:()=>e.reset("password","password_confirmation")})};return(t,l)=>(p(),k(P,null,{default:u(()=>[o(s(h),{title:"Register"}),r("form",{onSubmit:$(m,["prevent"])},[r("div",null,[o(i,{for:"first_name",value:"First Name"}),o(d,{id:"first_name",type:"text",class:"mt-1 block w-full",modelValue:s(e).first_name,"onUpdate:modelValue":l[0]||(l[0]=a=>s(e).first_name=a),required:"",autofocus:"",autocomplete:"name"},null,8,["modelValue"]),o(n,{class:"mt-2",message:s(e).errors.first_name},null,8,["message"])]),r("div",C,[o(i,{for:"last_name",value:"Last Name"}),o(d,{id:"last_name",type:"text",class:"mt-1 block w-full",modelValue:s(e).last_name,"onUpdate:modelValue":l[1]||(l[1]=a=>s(e).last_name=a),required:"",autofocus:"",autocomplete:"name"},null,8,["modelValue"]),o(n,{class:"mt-2",message:s(e).errors.last_name},null,8,["message"])]),r("div",R,[o(i,{for:"phone",value:"Phone"}),o(A,{id:"phone",class:"mt-1 block w-full",modelValue:s(e).phone,"onUpdate:modelValue":l[2]||(l[2]=a=>s(e).phone=a),required:"",autofocus:"",autocomplete:"phone"},null,8,["modelValue"]),o(n,{class:"mt-2",message:s(e).errors.phone},null,8,["message"])]),r("div",T,[o(i,{for:"email",value:"Email"}),o(d,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:s(e).email,"onUpdate:modelValue":l[3]||(l[3]=a=>s(e).email=a),required:"",autocomplete:"username"},null,8,["modelValue"]),o(n,{class:"mt-2",message:s(e).errors.email},null,8,["message"])]),r("div",j,[o(i,{for:"password",value:"Password"}),o(d,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:s(e).password,"onUpdate:modelValue":l[4]||(l[4]=a=>s(e).password=a),required:"",autocomplete:"new-password"},null,8,["modelValue"]),o(n,{class:"mt-2",message:s(e).errors.password},null,8,["message"])]),r("div",z,[o(i,{for:"password_confirmation",value:"Confirm Password"}),o(d,{id:"password_confirmation",type:"password",class:"mt-1 block w-full",modelValue:s(e).password_confirmation,"onUpdate:modelValue":l[5]||(l[5]=a=>s(e).password_confirmation=a),required:"",autocomplete:"new-password"},null,8,["modelValue"]),o(n,{class:"mt-2",message:s(e).errors.password_confirmation},null,8,["message"])]),r("div",E,[o(s(q),{href:t.route("login"),class:"underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"},{default:u(()=>[c(" Already registered? ")]),_:1},8,["href"]),o(B,{class:U(["ms-4",{"opacity-25":s(e).processing}]),disabled:s(e).processing},{default:u(()=>[c(" Register ")]),_:1},8,["class","disabled"])])],32)]),_:1}))}};export{G as default};
