@php
    $data = $ticket->data;
    $ora = $ticket->ora;
    $riga = 1
@endphp
<br />
<table id="titolo">
    <tr>
        <td style="text-align: left" ><strong>Ticket n° {{ $ticket->ticket }} > {{ $ticket->ticketType->nome }} > {{ $ticket->service->name }}</strong></td>
        <td style="text-align: right" ><strong>{{ date_format($ticket->data,"d/m/Y") }}</strong></td>
        <td style="text-align: right" ><strong>{{ date_format($ticket->ora,"h:i") }}</strong></td>
    </tr>
</table>
<br />
<table id="ropco">
    <tr>
        <th>N.</th>
        <th>user</th>
        <th>Data</th>
        <th>messaggio</th>
    </tr>
    @foreach($ticket->messages as $messaggi)
    <tr>
        <td style="text-align: right; width: 4%;">{{ $riga }}</td>
        <td style="text-align: center; width: 12%;">{{ $messaggi->user->name}}</td>
        <td style="text-align: center; width: 14%;">{{ date_format($messaggi->created_at,"d/m/Y h:i") }}</td>
        <td style="text-align: justify; width: 70%;">{{ $messaggi->messaggio }}</td>
    </tr>
        @php
            $riga += 1
        @endphp
    @endforeach
</table>
<br />
Saluti
<style>
    table{
        width: 100%;
        font-size: 115%;
    }
    #corpo th{
        background-color: #AF7280;
        border-bottom: #Af2937 1px solid;
        color:#FFF;
        font-weight: bold;
        min-height: 30px;
    }
    #corpo td{
        background-color: #FDD;
        border-bottom: #Af2937 1px solid;
        min-height: 30px;
    }
    #porco th{
        background-color: #a6933e;
        border-bottom: #f6ce2c 1px solid;
        color:#FFF;
        font-weight: bold;
        min-height: 30px;
    }
    #porco td{
        background-color: #e7cea2;
        border-bottom: #f6ce2c 1px solid;
        min-height: 30px;
    }
    #ropco th{
        background-color: #426cb4;
        border-bottom: #3266f3 1px solid;
        color:#FFF;
        font-weight: bold;
        min-height: 30px;
    }
    #ropco td{
        background-color: #78daf3;
        border-bottom: #3266f3 1px solid;
        min-height: 30px;
    }
    #titolo th{
        background-color: #6b7280;
        border-bottom: #1f2937 1px solid;
        color:#FFF;
        font-weight: bold;
    }
    #titolo td{
        background-color: #edf2f7;
        border-bottom: #3d4852 1px solid;
    }
</style>
