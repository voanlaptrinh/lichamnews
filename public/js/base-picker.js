class BasePicker{constructor(config){this.currentYear=config.currentYear;this.currentMonth=config.currentMonth;this.currentDay=config.currentDay;this.labels=config.labels||[];this.dataValues=config.dataValues||[];this.ajaxUrl=config.ajaxUrl;this.calendarAjaxUrl=config.calendarAjaxUrl;this.currentChart=null;this.overlay=null;this.lunarCache={};this.apiCache={};this.cacheTimeout=300000;this.eventListeners=[]}
getCurrentDate(){return new Date(this.currentYear,this.currentMonth-1,this.currentDay)}
debounce(func,delay){let timeoutId;return function(...args){clearTimeout(timeoutId);timeoutId=setTimeout(()=>func.apply(this,args),delay)}}
getCsrfToken(){return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')||''}
validateDate(day,month,year){return day>=1&&day<=31&&month>=1&&month<=12&&year>=1800&&year<=2300}
showToast(message,type='info'){document.querySelectorAll('.toast').forEach(toast=>toast.remove());const toast=document.createElement('div');toast.className=`toast toast-${type}`;toast.textContent=message;toast.style.cssText=`
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: ${type === 'error' ? '#f44336' : '#4caf50'};
            color: white;
            border-radius: 4px;
            z-index: 10000;
            opacity: 0;
            transition: opacity 0.3s;
            max-width: 300px;
        `;document.body.appendChild(toast);requestAnimationFrame(()=>toast.style.opacity='1');setTimeout(()=>{toast.style.opacity='0';setTimeout(()=>toast.remove(),300)},3000)}
addEventListenerTracked(element,event,handler,options={}){element.addEventListener(event,handler,options);this.eventListeners.push({element,event,handler,options});return{element,event,handler,options}}
destroy(){this.eventListeners.forEach(({element,event,handler})=>{if(element&&element.removeEventListener){element.removeEventListener(event,handler)}});this.eventListeners=[];this.lunarCache={};this.apiCache={};if(this.currentChart){this.currentChart.destroy();this.currentChart=null}
if(this.overlay){this.overlay.remove();this.overlay=null}}
getCacheKey(prefix,...args){return `${prefix}_${args.join('_')}`}
setCache(key,data){this.apiCache[key]={data,timestamp:Date.now()}}
getCache(key){const cached=this.apiCache[key];if(cached&&(Date.now()-cached.timestamp)<this.cacheTimeout){return cached.data}
delete this.apiCache[key];return null}
async generatePopupCalendarOptimized(month,year,highlightDay=null){const calendarDays=document.getElementById('popupCalendarDays');if(!calendarDays)return;const firstDay=new Date(year,month-1,1);const lastDay=new Date(year,month,0);const daysInMonth=lastDay.getDate();const startingDayOfWeek=firstDay.getDay()===0?6:firstDay.getDay()-1;let calendarHTML='';for(let i=0;i<startingDayOfWeek;i++){calendarHTML+='<div class="calendar-day empty"></div>'}
const selectedDay=highlightDay||parseInt(document.getElementById('solarDay')?.value||this.currentDay);const selectedMonth=parseInt(document.getElementById('solarMonth')?.value||this.currentMonth);const selectedYear=parseInt(document.getElementById('solarYear')?.value||this.currentYear);for(let day=1;day<=daysInMonth;day++){const isSelected=(year===selectedYear&&month===selectedMonth&&day===selectedDay);const selectedClass=isSelected?' current-day selected':'';calendarHTML+=`
                <div class="calendar-day${selectedClass}" style="position: relative" data-day="${day}" data-month="${month}" data-year="${year}">
                    <span>${day}</span>
                    <div class="lunar-date-popup" data-day="${day}">...</div>
                </div>
            `}
calendarDays.innerHTML=calendarHTML;this.setupCalendarDayListeners(calendarDays,month,year);this.updateLunarDatesOptimized(calendarDays,month,year,daysInMonth)}
async updateLunarDatesOptimized(calendarDays,month,year,daysInMonth){const cacheKey=this.getCacheKey('lunar',year,month);const cachedData=this.getCache(cacheKey);if(cachedData){this.applyLunarDatesToCalendar(calendarDays,cachedData);return}
try{const lunarDatesMap=await this.fetchLunarDatesForMonth(month,year,daysInMonth);this.setCache(cacheKey,lunarDatesMap);this.applyLunarDatesToCalendar(calendarDays,lunarDatesMap)}catch(error){this.showToast('Lỗi tải dữ liệu âm lịch','error')}}
applyLunarDatesToCalendar(calendarDays,lunarDatesMap){const lunarSpans=calendarDays.querySelectorAll('.lunar-date-popup[data-day]');lunarSpans.forEach(span=>{const day=parseInt(span.dataset.day);if(lunarDatesMap[day]){const lunarData=lunarDatesMap[day];let displayText=lunarData.lunarDay;if(day==1||lunarData.lunarDay==1){displayText=`${lunarData.lunarDay}/${lunarData.lunarMonth}`}span.textContent=displayText}})}
updatePopupHeader(month,year){const monthSpan=document.getElementById('popupMonth');const yearSpan=document.getElementById('popupYear');if(monthSpan)monthSpan.textContent=month.toString().padStart(2,'0');if(yearSpan)yearSpan.textContent=year}
closePopup(overlay){overlay.classList.remove('show');document.body.classList.remove('modal-open');document.body.classList.remove('has-scrollbar');setTimeout(()=>{overlay.style.display='none'},300)}
async fetchWithCache(url,options,cacheKey){const cachedData=this.getCache(cacheKey);if(cachedData){return cachedData}
try{const response=await fetch(url,{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':this.getCsrfToken(),'Accept':'application/json'},...options});const data=await response.json();if(data.success){this.setCache(cacheKey,data)}
return data}catch(error){throw error}}
async fetchLunarDatesForMonth(month,year,daysInMonth){const cacheKey=this.getCacheKey('lunar_month',year,month);try{const data=await this.fetchWithCache('/api/get-month-lunar-dates',{body:JSON.stringify({month:month,year:year})},cacheKey);if(data.success&&data.dates){return data.dates}else{throw new Error(data.error||'Lỗi lấy dữ liệu âm lịch')}}catch(error){throw error}}
async convertSolarToLunar(){const solarDay=document.getElementById('solarDay')?.value;const solarMonth=document.getElementById('solarMonth')?.value;const solarYear=document.getElementById('solarYear')?.value;if(!this.validateDate(parseInt(solarDay),parseInt(solarMonth),parseInt(solarYear))){this.showToast('Ngày không hợp lệ','error');return}
const cacheKey=this.getCacheKey('solar_to_lunar',solarYear,solarMonth,solarDay);try{const data=await this.fetchWithCache('/api/convert-solar-to-lunar',{body:JSON.stringify({solarDay:parseInt(solarDay),solarMonth:parseInt(solarMonth),solarYear:parseInt(solarYear)})},cacheKey);if(data.success){const lunarDaySelect=document.getElementById('lunarDay');const lunarMonthSelect=document.getElementById('lunarMonth');const lunarYearSelect=document.getElementById('lunarYear');if(lunarDaySelect)lunarDaySelect.value=data.lunarDay;if(lunarMonthSelect)lunarMonthSelect.value=data.lunarMonth;if(lunarYearSelect)lunarYearSelect.value=data.lunarYear}}catch(error){this.showToast('Lỗi chuyển đổi lịch','error')}}
async convertLunarToSolar(){const lunarDay=document.getElementById('lunarDay')?.value;const lunarMonth=document.getElementById('lunarMonth')?.value;const lunarYear=document.getElementById('lunarYear')?.value;if(!this.validateDate(parseInt(lunarDay),parseInt(lunarMonth),parseInt(lunarYear))){this.showToast('Ngày âm lịch không hợp lệ','error');return}
const cacheKey=this.getCacheKey('lunar_to_solar',lunarYear,lunarMonth,lunarDay);try{const data=await this.fetchWithCache('/api/convert-lunar-to-solar',{body:JSON.stringify({lunarDay:parseInt(lunarDay),lunarMonth:parseInt(lunarMonth),lunarYear:parseInt(lunarYear)})},cacheKey);if(data.success){document.getElementById('solarDay').value=data.solarDay;document.getElementById('solarMonth').value=data.solarMonth;document.getElementById('solarYear').value=data.solarYear;this.updatePopupHeader(data.solarMonth,data.solarYear);await this.generatePopupCalendarOptimized(data.solarMonth,data.solarYear,data.solarDay)}}catch(error){this.showToast('Lỗi chuyển đổi lịch âm','error')}}
setupCalendarDayListeners(calendarDays,month,year){throw new Error('setupCalendarDayListeners must be implemented by subclass')}
init(){}
onDateSelected(year,month,day){}}
window.BasePicker=BasePicker