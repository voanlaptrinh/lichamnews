 <div class="quick-picker-overlay" id="quickPickerOverlay">
        <div class="quick-picker-modal">
            <button class="close-btn-popup" id="closeQuickPicker">
                <i class="bi bi-x"></i>
            </button>
            <div class="quick-picker-header">
                <h4 class="quick-picker-title">THÁNG <span id="popupMonth">{{ str_pad($mm, 2, '0', STR_PAD_LEFT) }}</span> -
                    <span id="popupYear">{{ $yy }}</span></h4>
                <div class="quick-picker-nav">
                    <button class="nav-btn" id="prevMonthBtn"><i class="bi bi-chevron-left"></i></button>
                    <button class="nav-btn" id="nextMonthBtn"><i class="bi bi-chevron-right"></i></button>
                </div>

            </div>
            <div class="quick-picker-calendar">
                <div class="weekdays">
                    <div class="weekday-popup">Th 2</div>
                    <div class="weekday-popup">Th 3</div>
                    <div class="weekday-popup">Th 4</div>
                    <div class="weekday-popup">Th 5</div>
                    <div class="weekday-popup">Th 6</div>
                    <div class="weekday-popup">Th 7</div>
                    <div class="weekday-popup">CN</div>
                </div>
                <div class="calendar-days" id="popupCalendarDays">
                    <!-- Days will be populated by JavaScript -->
                </div>
            </div>

            <div class="quick-picker-forms">
                <div class="form-section-popup">
                    <div class="form-header-popup">
                        <i class="bi bi-brightness-high"></i>
                        <span>Dương Lịch</span>
                    </div>
                    <div class="form-row">
                        <select id="solarDay" class="form-select form-select-config">
                            @for ($i = 1; $i <= 31; $i++)
                                <option value="{{ $i }}" {{ $i == $dd ? 'selected' : '' }}>Ngày
                                    {{ $i }}</option>
                            @endfor
                        </select>
                        <select id="solarMonth" class="form-select form-select-config">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $i == $mm ? 'selected' : '' }}>Tháng
                                    {{ $i }}</option>
                            @endfor
                        </select>
                        <select id="solarYear" class="form-select form-select-config">
                            @for ($i = 1900; $i <= 2100; $i++)
                                <option value="{{ $i }}" {{ $i == $yy ? 'selected' : '' }}>{{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="form-section-popup">
                    <div class="form-header-popup">
                        <i class="bi bi-moon"></i>
                        <span>Âm Lịch</span>
                    </div>
                    <div class="form-row">
                        <select id="lunarDay" class="form-select form-select-config">
                            @for ($i = 1; $i <= 30; $i++)
                                <option value="{{ $i }}">Ngày {{ $i }}</option>
                            @endfor
                        </select>
                        <select id="lunarMonth" class="form-select form-select-config">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">Tháng {{ $i }}</option>
                            @endfor
                        </select>
                        <select id="lunarYear" class="form-select form-select-config">
                            @for ($i = 1900; $i <= 2100; $i++)
                                <option value="{{ $i }}" {{ $i == $yy ? 'selected' : '' }}>{{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>

            <div class="quick-picker-footer">
                <button class="btn-view" id="viewDateBtn">XEM</button>
            </div>
        </div>
    </div>