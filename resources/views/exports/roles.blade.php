<table>
    <thead>
        <tr style="background-color: #f3f4f6; font-weight: bold;">
            <th style="border: 1px solid #d1d5db; padding: 8px;">No</th>
            <th style="border: 1px solid #d1d5db; padding: 8px;">Nama Role</th>
            <th style="border: 1px solid #d1d5db; padding: 8px;">Deskripsi</th>
            <th style="border: 1px solid #d1d5db; padding: 8px;">Jumlah User</th>
            <th style="border: 1px solid #d1d5db; padding: 8px;">Dibuat Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($records as $i => $row)
            <tr>
                <td style="border: 1px solid #d1d5db; padding: 8px;">{{ $i + 1 }}</td>
                <td style="border: 1px solid #d1d5db; padding: 8px;">{{ $row->name }}</td>
                <td style="border: 1px solid #d1d5db; padding: 8px;">{{ $row->description ?? '-' }}</td>
                <td style="border: 1px solid #d1d5db; padding: 8px; text-align: center;">{{ $row->users_count }}</td>
                <td style="border: 1px solid #d1d5db; padding: 8px;">{{ $row->created_at->format('d-m-Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
