<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Project;

class ProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Insert projects */

        $projects = [
            [1, 7795294, 'Garpa Redesign', '2016-04-28 13:20:52', '2016-06-29 12:40:46', NULL],
            [2, 7794735, 'ABH', '2016-04-28 14:58:54', '2016-06-29 12:29:26', NULL],
            [3, 7794720, 'Audi AIO', '2016-04-29 05:41:18', '2016-06-29 12:49:25', NULL],
            [4, 7794853, 'Steelcase', '2016-04-29 08:02:37', '2016-06-29 12:35:51', NULL],
            [5, 7795463, 'Vichy Schulungsportal - Vichy Durchblick Herbst 2016', '2016-04-29 11:10:17', '2016-06-29 12:39:27', NULL],
            [6, 7795462, 'Vichy Schulungsportal - Vichy on Tour Herbst 2016', '2016-04-29 11:10:40', '2016-06-29 12:41:31', NULL],
            [7, 7794736, 'Garpa Support', '2016-05-02 07:01:43', '2016-06-29 12:43:10', NULL],
            [8, 7794736, 'Garpa', '2016-05-03 14:47:24', '2016-06-29 12:45:50', NULL],
            [9, 7794744, 'HLX/LHH', '2016-05-17 05:38:34', '2016-06-29 12:51:50', NULL],
            [10, 7796149, 'CAD Seminarportal Update 2017', '2016-05-17 06:42:19', '2016-11-02 14:18:57', NULL],
            [11, 7795580, 'Star Energiewerke', '2016-05-17 13:19:58', '2016-06-29 13:07:00', NULL],
            [12, 7795307, 'Otterbach NetProject 2016', '2016-05-19 09:24:02', '2016-06-29 13:08:20', NULL],
            [13, 7795581, 'NDR', '2016-06-01 07:29:03', '2016-06-29 13:45:36', NULL],
            [14, 7794739, 'Mair Dumont', '2016-06-01 09:32:48', '2016-06-29 13:50:48', NULL],
            [15, 7795582, 'Fachzentrum AT', '2016-06-01 12:23:56', '2016-06-29 13:48:36', NULL],
            [16, 7795087, 'CAD', '2016-06-16 20:59:18', '2016-06-29 14:09:58', NULL],
            [17, 7795082, 'LRP Schulungsportal', '2016-06-23 08:04:12', '2016-06-29 14:18:31', NULL],
            [18, 7795583, 'Otterbach IntranetDB 2016', '2016-06-29 13:09:45', '2016-06-29 14:08:14', NULL],
            [19, 7795559, 'CAD Seminarportal Zusatzarbeiten', '2016-06-29 13:53:43', '2016-06-29 13:56:53', NULL],
            [20, 7794574, 'Otterbach Basement', '2016-07-06 06:51:26', '2016-07-07 06:15:45', NULL],
            [21, 7796176, 'KAS Ausschreibung', '2016-07-22 11:12:21', '2016-11-02 15:09:00', NULL],
            [22, 7796177, 'LRP.at Schulungsportal Herbst 2016', '2016-08-18 11:57:55', '2016-11-02 15:14:29', NULL],
            [23, 7796178, 'Otterbach Feuerwehrkalender', '2016-09-07 14:40:29', '2016-11-02 15:25:04', NULL],
            [24, 7796171, 'SEAT Adventskalender', '2016-09-21 09:10:41', '2016-11-02 14:13:17', NULL],
            [25, 7796179, 'Fotowand', '2016-10-18 13:16:07', '2016-11-02 15:35:52', NULL],
            [26, 7794906, 'ADA X-Mas Shopping', '2016-10-28 07:42:02', '2016-11-02 15:51:00', NULL],
            [27, 7796177, 'LRP.at Schulungsportal Feedback-Modul', '2016-11-03 09:31:29', '2016-11-03 09:32:57', NULL],
            [28, 7796184, 'LRP.at Schulungsportal Support 2016', '2016-11-03 09:41:58', '2016-11-07 05:12:29', NULL],
            [29, 7796207, 'Rutronik WM-Gewinnspiel 2016', '2016-11-03 20:51:32', '2016-11-07 05:17:27', NULL],
            [30, 7796208, 'Otterbach Support Inventory', '2016-11-03 20:54:45', '2016-11-07 05:19:38', NULL],
            [31, 7796193, 'Bahn Asset-DB', '2016-11-03 22:21:29', '2016-11-04 07:05:47', NULL],
            [32, 7796214, 'Vichy Schulungsportal - Vichy on Tour Frühjahr 2017', '2016-11-07 13:44:24', '2016-11-08 07:04:58', NULL],
            [33, 7796215, 'Vichy Schulungsportal - Vichy Durchblick Frühjahr 2017', '2016-11-08 07:06:44', '2016-11-08 07:08:14', NULL],
            [34, 7796436, 'Audi Content-Plan Support 2016', '2016-11-15 09:13:52', '2016-12-19 15:27:24', NULL],
            [35, NULL, 'Bott', '2016-11-21 14:00:33', '2016-11-21 14:00:33', NULL],
            [36, 7796466, 'Audi AIO 2017', '2016-12-19 15:35:12', '2017-04-18 11:14:40', NULL],
            [37, 7796448, 'LRP.at Schulungsportal Frühjahr 2017', '2016-12-20 09:10:22', '2016-12-21 16:08:53', NULL],
            [38, 7796446, 'Cosmetique Active Seminarportal 2017', '2016-12-21 15:25:51', '2016-12-21 16:12:12', NULL],
            [39, NULL, 'Audi Ai', '2016-12-21 21:34:09', '2016-12-21 21:34:09', NULL],
            [40, 7796380, 'HLX 2017', '2016-12-21 22:16:29', '2016-12-21 22:40:20', NULL],
            [41, 7796937, 'Otterbach NetProject 2017', '2017-01-03 14:52:27', '2017-04-18 07:56:23', NULL],
            [42, 7796942, 'Fachzentrum AT 2017', '2017-01-03 15:03:47', '2017-04-18 10:52:03', NULL],
            [43, 7796372, 'Garpa 2017', '2017-01-04 11:52:25', '2017-04-18 10:55:04', NULL],
            [44, 7796380, 'HLX/LHH 2017', '2017-01-04 16:23:17', '2017-04-18 11:02:33', NULL],
            [45, 7796943, 'Basement 2017', '2017-01-05 14:54:09', '2017-04-18 11:08:41', NULL],
            [46, 7796375, 'Mair Dumont 2017', '2017-01-16 10:21:07', '2017-04-18 11:17:44', NULL],
            [47, 7796944, 'LRP.de Schulungsportal 2017', '2017-01-19 20:20:46', '2017-04-18 11:23:00', NULL],
            [48, 7796945, 'CAD 2017', '2017-01-19 20:34:21', '2017-04-18 11:29:30', NULL],
            [49, 7796440, 'ADA Be Different 2017', '2017-01-23 13:36:30', '2017-04-18 11:31:56', NULL],
            [50, 7796946, 'Vichy Schulungsportal Backend 2017', '2017-01-25 09:31:20', '2017-04-18 11:38:15', NULL],
            [51, 7796948, 'LRP.at Schulungsportal Sonnenschutz-Symposium', '2017-02-09 14:02:37', '2017-04-18 11:51:44', NULL],
            [52, 7796946, 'Vichy Schulungsportal Backend 2017', '2017-02-15 09:38:33', '2017-04-18 11:53:17', NULL],
            [53, 7796373, 'Olsen Image-DB 2017', '2017-02-15 13:41:03', '2017-04-18 12:11:46', NULL],
            [54, 7796379, 'ABH Support 2017', '2017-02-28 09:29:06', '2017-04-18 12:16:22', NULL],
            [55, 7796469, 'NDR TopicSurf 2017', '2017-03-10 07:37:23', '2017-04-18 12:19:37', NULL],
            [56, 7796950, 'Audi Content-Plan Support 2017', '2017-03-15 07:49:54', '2017-04-18 12:23:32', NULL],
            [57, 7796396, 'Ars Mundi TopicSurf 2017', '2017-03-15 11:20:55', '2017-04-18 12:24:26', NULL],
            [58, 7796951, 'Bitburger 3D-Dosenanimation', '2017-03-22 19:19:09', '2017-04-18 12:27:14', NULL],
            [59, 7796952, 'LRP.at Schulungsportal Support 2017', '2017-04-18 09:45:26', '2017-04-18 12:38:22', NULL],
            [60, 7796947, 'Vichy Schulungsportal - Vichy Durchblick Support 2017', '2017-04-18 12:40:11', '2017-04-18 12:45:09', NULL],
            [61, 7796955, 'Coltene 3D-Animation 2017', '2017-04-18 14:06:53', '2017-04-18 14:09:16', NULL],
            [62, 7797174, 'IKK Web-to-Print', '2017-04-24 05:22:05', '2017-06-26 07:25:58', NULL],
            [63, 7796214, 'Vichy Schulungsportal - Vichy on Tour Support 2017', '2017-04-24 14:15:21', '2017-06-26 07:28:10', NULL],
            [64, 7797175, 'IHK Relaunch', '2017-06-20 07:21:32', '2017-06-26 08:05:01', NULL],
            [65, NULL, 'LRP Trainingsportal.de - Update Herbst 2017', '2017-07-04 12:08:21', '2017-07-04 12:08:21', NULL],
            [66, NULL, 'ADA Be Different Landing Page Redesign', '2017-07-10 07:26:14', '2017-07-10 07:26:14', NULL],
            [67, NULL, 'Vichy Schulungsportal - Vichy Durchblick Herbst 2017', '2017-07-20 09:36:32', '2017-07-20 09:36:32', NULL],
            [68, NULL, 'Ars Mundi FileMaker-Support', '2017-08-02 05:48:43', '2017-08-02 05:48:43', NULL],
            [69, NULL, 'Giner 360 Grad 2017', '2017-08-04 07:39:12', '2017-08-04 07:39:12', NULL],
            [70, NULL, 'LRP.at Schulungsportal Herbst 2017', '2017-08-09 08:10:35', '2017-08-09 08:10:35', NULL],
            [71, NULL, 'ADA X-Mas Shop 2017', '2017-09-07 07:52:05', '2017-09-07 07:52:05', NULL],
            [72, NULL, 'ADA Adventskalender 2017', '2017-09-07 07:52:25', '2017-09-07 07:52:25', NULL],
            [73, NULL, 'Turi Blätterkatalog 10/2017', '2017-10-25 07:19:19', '2017-10-25 07:19:19', NULL],
            [74, NULL, 'Vichy Villa Vichy 2017', '2017-11-23 15:55:37', '2017-11-23 15:55:37', NULL],
            [75, NULL, 'Turi Blätterkatalog Ausgabe 1', '2017-11-24 15:20:55', '2017-11-24 15:20:55', NULL],
            [76, NULL, 'Turi Blätterkatalog Ausgabe 2', '2017-11-24 15:21:04', '2017-11-24 15:21:04', NULL],
            [77, NULL, 'Turi Blätterkatalog Ausgabe 3', '2017-11-24 15:21:08', '2017-11-24 15:21:08', NULL],
            [78, NULL, 'Turi Blätterkatalog Ausgabe 4', '2017-11-24 15:21:12', '2017-11-24 15:21:12', NULL],
            [79, NULL, 'Vichy Schulungsportal Neu-Entwicklung 2017', '2017-11-24 19:06:57', '2017-11-24 19:06:57', NULL],
            [80, NULL, 'LRP.at Schulungsportal Frühjahr 2018', '2017-11-29 08:57:29', '2017-11-29 08:57:29', NULL],
            [81, NULL, 'LRP.de Schulungsportal Frühjahr 2018', '2017-12-19 17:20:53', '2017-12-19 17:20:53', NULL],
            [82, NULL, 'Otterbach NetProject 2018', '2018-01-04 10:22:28', '2018-01-04 10:22:28', NULL],
            [83, NULL, 'Audi AIO 2018', '2018-01-08 09:58:18', '2018-01-08 09:58:18', NULL],
            [84, NULL, 'Dr. Wiesner Support 2018', '2018-01-09 15:26:54', '2018-01-09 15:26:54', NULL],
            [85, NULL, 'Garpa Support 2018', '2018-01-09 15:27:42', '2018-01-09 15:27:42', NULL],
            [86, NULL, 'Star.Energiewerke Bewerbermanagement-Tool 2018', '2018-01-09 15:28:34', '2018-01-09 15:28:34', NULL],
            [87, NULL, 'Vichy Villa Vichy 2018', '2018-01-09 17:04:24', '2018-01-09 17:04:24', NULL],
            [88, NULL, 'Mair Dumont MediaTool 2018', '2018-01-11 19:59:08', '2018-01-11 19:59:08', NULL],
            [89, NULL, 'Fachzentrum AT Support 2018', '2018-01-16 08:02:19', '2018-01-16 08:02:19', NULL],
        ];

        foreach ($projects as $project) {
            list($id, $np_id, $name, $created_at, $updated_at, $deleted_at) = $project;

            $project = new Project;
            $project->np_id = $np_id;
            $project->name = $name;
            $project->created_at = $created_at;
            $project->updated_at = $updated_at;
            $project->deleted_at = $deleted_at;
            $project->timestamps = false;
            $project->save();
        }
    }
}
