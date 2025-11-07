import{r as d,j as e}from"./app-FMwqptGY.js";import{c as o}from"./createLucideIcon-81QVAIuW.js";/**
 * @license lucide-react v0.553.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const l=[["path",{d:"M12 19v3",key:"npa21l"}],["path",{d:"M19 10v2a7 7 0 0 1-14 0v-2",key:"1vc78b"}],["rect",{x:"9",y:"2",width:"6",height:"13",rx:"3",key:"s6n7sd"}]],u=o("mic",l);/**
 * @license lucide-react v0.553.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const p=[["path",{d:"m16 6-8.414 8.586a2 2 0 0 0 2.829 2.829l8.414-8.586a4 4 0 1 0-5.657-5.657l-8.379 8.551a6 6 0 1 0 8.485 8.485l8.379-8.551",key:"1miecu"}]],x=o("paperclip",p);/**
 * @license lucide-react v0.553.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const m=[["path",{d:"M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z",key:"1ffxy3"}],["path",{d:"m21.854 2.147-10.94 10.939",key:"12cjpa"}]],y=o("send",m);/**
 * @license lucide-react v0.553.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const f=[["circle",{cx:"12",cy:"12",r:"10",key:"1mglay"}],["path",{d:"M8 14s1.5 2 4 2 4-2 4-2",key:"1y1vjs"}],["line",{x1:"9",x2:"9.01",y1:"9",y2:"9",key:"yxxnd0"}],["line",{x1:"15",x2:"15.01",y1:"9",y2:"9",key:"1p4y9e"}]],b=o("smile",f);function j({onSend:i,sending:t=!1}){const[r,n]=d.useState("");function c(s){s.preventDefault();const a=r.trim();!a||t||(i(a),n(""))}return e.jsxs("form",{onSubmit:c,className:"px-4 py-2 bg-card border-t border-border flex gap-2 items-center",children:[e.jsx("button",{type:"button",className:"p-2 text-muted-foreground hover:text-foreground transition-colors",children:e.jsx(b,{size:24})}),e.jsx("button",{type:"button",className:"p-2 text-muted-foreground hover:text-foreground transition-colors",children:e.jsx(x,{size:24})}),e.jsx("input",{value:r,onChange:s=>n(s.target.value),className:"flex-1 rounded-full border-0 bg-secondary px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary",placeholder:"Digite uma mensagem",disabled:t}),r.trim()?e.jsx("button",{type:"submit",disabled:t,className:"p-2 rounded-full transition-colors disabled:opacity-50",style:{backgroundColor:"#481e4d",color:"white"},children:t?e.jsx("div",{className:"h-5 w-5 border-2 border-t-white border-white/30 rounded-full animate-spin"}):e.jsx(y,{size:20})}):e.jsx("button",{type:"button",className:"p-2 text-muted-foreground hover:text-foreground transition-colors",children:e.jsx(u,{size:24})})]})}export{j as default};
