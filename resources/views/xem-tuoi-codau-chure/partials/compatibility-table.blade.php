<div class="table-responsive">
    <table class="table table-bordered align-middle">
        <thead class="text-center" style="background-color: #e8ebee;">
            <tr>
                <th style="border-radius: 8px 0 0 8px">Tiêu chí</th>
                <th>Bình giải</th>
                {{-- <th>{{ $direction['from_label'] }}</th>
                <th>{{ $direction['to_label'] }}</th> --}}
                {{-- <th>Mối quan hệ</th> --}}
                <th style="border-radius: 0 8px 8px 0">Điểm</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Ngũ Hành Nạp Âm</strong></td>
                <td>
                    <div>
                        Mệnh của {{ $direction['from_label'] }}: {{ $person1['nap_am'] }}
                    </div>
                    <div>
                        Mệnh của {{ $direction['to_label'] }}: {{ $person2['nap_am'] }}
                    </div>
                </td>
                {{-- <td>{{ $person1['nap_am'] }}</td>
                <td>{{ $person2['nap_am'] }}</td> --}}
                {{-- <td>{{ $direction['details']['ngu_hanh_nap_am']['relation'] }}</td> --}}
                <td class="text-center">
                    <div>
                        {{ $direction['details']['ngu_hanh_nap_am']['score'] }}
                    </div>
                    <div>
                        ({{ $direction['details']['ngu_hanh_nap_am']['relation'] }})
                    </div>
                    {{-- <span class="badge {{ $direction['details']['ngu_hanh_nap_am']['score'] == 2 ? 'bg-success' : ($direction['details']['ngu_hanh_nap_am']['score'] == 1 ? 'bg-warning text-dark' : 'bg-danger') }}">
                        {{ $direction['details']['ngu_hanh_nap_am']['score'] }}
                    </span> --}}
                </td>
            </tr>
            <tr>
                <td><strong>Thiên Can</strong></td>
                <td>
                    <div>
                        Thiên can của {{ $direction['from_label'] }}: {{ $person1['thien_can'] }}
                    </div>
                    <div>
                        Thiên can của {{ $direction['to_label'] }}: {{ $person2['thien_can'] }}
                    </div>
                </td>
                {{-- <td>{{ $person1['thien_can'] }}</td>
                <td>{{ $person2['thien_can'] }}</td> --}}
                {{-- <td>{{ $direction['details']['thien_can']['relation'] }}</td> --}}
                <td class="text-center">
                    <div>
                        {{ $direction['details']['thien_can']['score'] }}
                    </div>
                    <div>
                        ({{ $direction['details']['thien_can']['relation'] }})
                    </div>
                    {{-- <span
                        class="badge {{ $direction['details']['thien_can']['score'] == 2 ? 'bg-success' : ($direction['details']['thien_can']['score'] == 1 ? 'bg-warning text-dark' : 'bg-danger') }}">
                        {{ $direction['details']['thien_can']['score'] }}
                    </span> --}}
                </td>
            </tr>
            <tr>
                <td><strong>Địa Chi</strong></td>
                <td>
                    <div>
                        Địa chi của {{ $direction['from_label'] }}: {{ $person1['dia_chi'] }}
                    </div>
                    <div>
                        Địa chi của {{ $direction['to_label'] }}: {{ $person2['dia_chi'] }}
                    </div>
                </td>
                {{-- <td>{{ $person1['dia_chi'] }}</td>
                <td>{{ $person2['dia_chi'] }}</td> --}}
                {{-- <td>{{ $direction['details']['dia_chi']['relation'] }}</td> --}}
                <td class="text-center">
                    <div>
                        {{ $direction['details']['dia_chi']['score'] }}
                    </div>
                    <div>
                        ({{ $direction['details']['dia_chi']['relation'] }})
                    </div>
                    {{-- <span
                        class="badge {{ $direction['details']['dia_chi']['score'] == 2 ? 'bg-success' : ($direction['details']['dia_chi']['score'] == 1 ? 'bg-warning text-dark' : 'bg-danger') }}">
                        {{ $direction['details']['dia_chi']['score'] }}
                    </span> --}}
                </td>
            </tr>
            <tr>
                <td><strong>Cung Phi</strong></td>
                <td>
                    <div>
                        Cung phi của {{ $direction['from_label'] }}: {{ $person1['cung_phi'] }}
                    </div>
                    <div>
                        Cung phi của {{ $direction['to_label'] }}: {{ $person2['cung_phi'] }}
                    </div>
                </td>
                {{-- <td>{{ $person1['cung_phi'] }}</td>
                <td>{{ $person2['cung_phi'] }}</td>
                <td>{{ $direction['details']['cung_phi']['relation'] }}</td> --}}
                <td class="text-center">
                    <div>
                        {{ $direction['details']['cung_phi']['score'] }}
                    </div>
                    <div>
                        ({{ $direction['details']['cung_phi']['relation'] }})
                    </div>
                    {{-- <span
                        class="badge {{ $direction['details']['cung_phi']['score'] == 2 ? 'bg-success' : ($direction['details']['cung_phi']['score'] == 1 ? 'bg-warning text-dark' : 'bg-danger') }}">
                        {{ $direction['details']['cung_phi']['score'] }}
                    </span> --}}
                </td>
            </tr>
            <tr>
                <td><strong>Ngũ Hành Cung Phi</strong></td>
                <td>
                    <div>
                        Ngũ hành cung phi của {{ $direction['from_label'] }}: {{ $person1['cung_phi_hanh'] }}
                    </div>
                    <div>
                        Ngũ hành cung phi của {{ $direction['to_label'] }}: {{ $person2['cung_phi_hanh'] }}
                    </div>
                </td>
                {{-- <td>{{ $person1['cung_phi_hanh'] }}</td>
                <td>{{ $person2['cung_phi_hanh'] }}</td>
                <td>{{ $direction['details']['ngu_hanh_cung_phi']['relation'] }}</td> --}}
                <td class="text-center">
                    <div>
                        {{ $direction['details']['ngu_hanh_cung_phi']['score'] }}
                    </div>
                    <div>
                        ({{ $direction['details']['ngu_hanh_cung_phi']['relation'] }})
                    </div>
                    {{-- <span
                        class="badge {{ $direction['details']['ngu_hanh_cung_phi']['score'] == 2 ? 'bg-success' : ($direction['details']['ngu_hanh_cung_phi']['score'] == 1 ? 'bg-warning text-dark' : 'bg-danger') }}">
                        {{ $direction['details']['ngu_hanh_cung_phi']['score'] }}
                    </span> --}}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Tổng điểm</strong>
                </td>
                <td>
                    {{ $conclusion['title'] }}
                </td>
                <td class="text-center">
                    {{ $conclusion['score'] }}
                </td>
            </tr>
        </tbody>

    </table>
</div>
