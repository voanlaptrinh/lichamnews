 <div class="col-xl-3  col-sm-12 col-12 mb-3">
     <div class="d-flex flex-column gap-4">
         <!-- ** KHá»I Sá»° KIá»†N Sáº®P Tá»šI ** -->


         <div class="events-card">
             <div class="card-title-right title-tong-quan-h5-log">Tiện ích xem ngày</div>
             <ul class="list-group list-group-flush events-list">
                 <li class="list-group-item pb-0">
                     <a href="{{ route('totxau.form') }}" class="{{ request()->routeIs('totxau.form') ? 'active-tools' : '' }}">

                         <div class="event-details --padding-event-tot">
                             <div class="event-name" style="font-weight: unset">
                                 Xem ngày tốt xấu
                             </div>

                         </div>
                     </a>
                 </li>
                 <li class="list-group-item pb-0">
                     <a href="{{ route('buy-house.form') }}" class="{{ request()->routeIs('buy-house.form') ? 'active-tools' : '' }}">

                         <div class="event-details --padding-event-tot">
                             <div class="event-name" style="font-weight: unset">
                                 Xem ngày mua nhà
                             </div>

                         </div>
                     </a>
                 </li>
                 <li class="list-group-item  pb-0">
                     <a href="{{ route('astrology.form') }}" class="{{ request()->routeIs('astrology.form') ? 'active-tools' : '' }}">
                         <div class="event-details  --padding-event-tot">
                             <div class="event-name" style="font-weight: unset">
                                 Xem ngày kết hôn
                             </div>
                         </div>
                     </a>
                 </li>
                   <li class="list-group-item  pb-0">
                     <a href="{{ route('khai-truong.form') }}" class="{{ request()->routeIs('khai-truong.form') ? 'active-tools' : '' }}">
                         <div class="event-details  --padding-event-tot">
                             <div class="event-name" style="font-weight: unset">
                                 Xem ngày khai trương
                             </div>
                         </div>
                     </a>
                 </li>
             </ul>
         </div>
     </div>
 </div>
