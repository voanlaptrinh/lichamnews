 <div class="box--bg-thang mb-3">
     <h2 class="title-tong-quan-h2-log">Xem tử vi cung {{ $zodiac['name'] ?? 'Cung hoàng đạo' }}
     </h2>
     <div class="date-nav">
         <a href="{{ route('horoscope.show.type', ['signSlug' => $zodiac['sign'], 'typeSlug' => 'hom-nay']) }}">Hôm
             nay <i class="bi bi-chevron-right"
                 style="border: 1px solid rgb(194, 189, 189); border-radius: 50%; padding: 3px;"></i></a>
         <a href="{{ route('horoscope.show.type', ['signSlug' => $zodiac['sign'], 'typeSlug' => 'ngay-mai']) }}">Ngày mai <i class="bi bi-chevron-right"
                 style="border: 1px solid rgb(194, 189, 189); border-radius: 50%; padding: 3px;"></i></a>
         <a href="{{ route('horoscope.show.type', ['signSlug' => $zodiac['sign'], 'typeSlug' => 'tuan-nay']) }}">Tuần
             này <i class="bi bi-chevron-right"
                 style="border: 1px solid rgb(194, 189, 189); border-radius: 50%; padding: 3px;"></i></a>
         <a href="{{ route('horoscope.show.type', ['signSlug' => $zodiac['sign'], 'typeSlug' => 'thang-nay']) }}">Tháng
             này <i class="bi bi-chevron-right"
                 style="border: 1px solid rgb(194, 189, 189); border-radius: 50%; padding: 3px;"></i></a>
         <a href="{{ route('horoscope.show.type', ['signSlug' => $zodiac['sign'], 'typeSlug' => 'nam-nay']) }}">Năm
             2025 <i class="bi bi-chevron-right"
                 style="border: 1px solid rgb(194, 189, 189); border-radius: 50%; padding: 3px;"></i></a>
     </div>

 </div>
 @push('styles')
     <style>
         .date-nav {
             display: flex;
             gap: 10px;
             overflow-x: auto;
             scroll-snap-type: x mandatory;
             -webkit-overflow-scrolling: touch;
             padding: 10px 0;
             white-space: nowrap;
         }

         .date-nav::-webkit-scrollbar {
             height: 6px;
         }

         .date-nav::-webkit-scrollbar-thumb {
             background: #ccc;
             border-radius: 10px;
         }

         .date-nav a {
             flex: 0 0 auto;
             display: inline-block;
             padding: 8px 16px;
             border: 1px solid #007bff;
             background: #fff;
             color: #0d2b7e;
             border-radius: 20px;
             font-weight: 500;
             text-decoration: none;
             scroll-snap-align: start;
             transition: all 0.2s ease;
         }

         .date-nav a:hover,
         .date-nav a.active {
             background: #007bff;
             color: #fff;
         }

         /* 📱 Mobile */
         @media (max-width: 768px) {
             .date-nav {
                 gap: 8px;
             }

             .date-nav a {
                 padding: 6px 12px;
                 font-size: 14px;
             }
         }
     </style>
 @endpush
