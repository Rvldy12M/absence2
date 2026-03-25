<table>
    <thead>
        <tr style="background-color: #f3f4f6; font-weight: bold;">
            <th style="border: 1px solid #d1d5db; padding: 8px;">No</th>
            <th style="border: 1px solid #d1d5db; padding: 8px;">Nama</th>
            <th style="border: 1px solid #d1d5db; padding: 8px;">Email</th>
            <th style="border: 1px solid #d1d5db; padding: 8px;">Role</th>
            <th style="border: 1px solid #d1d5db; padding: 8px;">Dibuat Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($records as $i => $row)
            <tr>
                <td style="border: 1px solid #d1d5db; padding: 8px;">{{ $i + 1 }}</td>
                <td style="border: 1px solid #d1d5db; padding: 8px;">{{ $row->name }}</td>
                <td style="border: 1px solid #d1d5db; padding: 8px;">{{ $row->email }}</td>
                <td style="border: 1px solid #d1d5db; padding: 8px; text-align: center;">
                    <span style="padding: 4px 8px; border-radius: 4px; font-weight: bold;
                        @if($row->role === 'admin') background-color: #fee2e2; color: #991b1b;
                        @elseif($row->role === 'guru') background-color: #fef3c7; color: #92400e;
                        @else background-color: #dbeafe; color: #1e40af;
                        @endif">
                        {{ strtoupper($row->role) }}
                    </span>
                </td>
                <td style="border: 1px solid #d1d5db; padding: 8px;">{{ $row->created_at->format('d-m-Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
