
@extends('stu_compo.main')
@section('main-container')


    <main>
        <div class="exam timetable">
            <h2>Exam Available</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Subject</th>
                        <th>Room no.</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>13 May 2022</td>
                        <td>09-12 AM</td>
                        <td>CS200</td>
                        <td>38-718</td>
                    </tr>
                    <tr>
                        <td>16 May 2022</td>
                        <td>09-12 AM</td>
                        <td>DBMS130</td>
                        <td>38-718</td>
                    </tr>
                    <tr>
                        <td>18 May 2022</td>
                        <td>09-12 AM</td>
                        <td>MTH166</td>
                        <td>38-718</td>
                    </tr>
                    <tr>
                        <td>20 May 2022</td>
                        <td>09-12 AM</td>
                        <td>NS200</td>
                        <td>38-718</td>
                    </tr>
                    <tr>
                        <td>23 May 2022</td>
                        <td>09-12 AM</td>
                        <td>CS849</td>
                        <td>38-718</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
    </main>


    @endsection()