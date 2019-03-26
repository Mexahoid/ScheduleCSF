<?php
/**
 * Created by PhpStorm.
 * User: Mexahoid
 * Date: 23.03.2019
 * Time: 14:33
 */


include 'Connector.php';

class Logics
{
    var $connector;
    function Connect(){
        $this->connector = new Connector('mysql:host=localhost;dbname=lmb;charset=utf8', 'lmb', '22222222');
    }

    function GetRooms(){
        $arr = $this->connector->getData("SELECT * FROM Room", null);
        return $arr;
    }

    function AddRoom($newroom){
        $this->connector->saveData("INSERT INTO Room (Name) VALUES (?)", array($newroom));
    }

    function DeleteRoom($oldroom){
        $this->connector->saveData("DELETE FROM Room WHERE Name = ?", array($oldroom));
    }

    function ChangeRoom($oldroom, $newroom){
        $this->connector->saveData("UPDATE Room SET Name = ? WHERE Name = ?", array($newroom, $oldroom));
    }


    function GetTimeplaces(){
        $arr = $this->connector->getData("SELECT * FROM Timeplace", null);
        return $arr;
    }
    
    function GetTimeplacesOddity($oddity){
        $arr = $this->connector->getData("SELECT * FROM Timeplace WHERE Odd = ?", array($oddity));
        return $arr;
    }

    function AddTimeplace($newtime_start, $newtime_stop, $newtime_oddity){
        $this->connector->saveData("INSERT INTO Timeplace (Start, Stop, Odd) VALUES (?, ?, ?)", array($newtime_start, $newtime_stop, $newtime_oddity));
    }

    function DeleteTimeplace($oldtime_id){
        $this->connector->saveData("DELETE FROM Timeplace WHERE ID = ?", array($oldtime_id));
    }

    function ChangeTimeplace($oldtime_id, $newtime_start, $newtime_stop, $newtime_oddity){
        $this->connector->saveData("UPDATE Timeplace SET Start = ?, Stop = ?, Odd = ? WHERE ID = ?", array($newtime_start, $newtime_stop, $newtime_oddity, $oldtime_id));
    }


    function GetSubjects(){
        $arr = $this->connector->getData("SELECT * FROM Subject", null);
        return $arr;
    }

    function AddSubject($newsubject){
        $this->connector->saveData("INSERT INTO Subject (Name) VALUES (?)", array($newsubject));
    }

    function DeleteSubject($oldsubject){
        $this->connector->saveData("DELETE FROM Subject WHERE Name = ?", array($oldsubject));
    }

    function ChangeSubject($oldsubject, $newsubject){
        $this->connector->saveData("UPDATE Subject SET Name = ? WHERE Name = ?", array($newsubject, $oldsubject));
    }

    
    function GetDays(){
        $arr = $this->connector->getData("SELECT * FROM Day", null);
        return $arr;
    }

    function AddDay($newday){
        $this->connector->saveData("INSERT INTO Day (Name) VALUES (?)", array($newday));
    }

    function DeleteDay($oldday){
        $this->connector->saveData("DELETE FROM Day WHERE Name = ?", array($oldday));
    }

    function ChangeDay($oldday, $newday){
        $this->connector->saveData("UPDATE Day SET Name = ? WHERE Name = ?", array($newday, $oldday));
    }
    

    function GetCourses(){
        $arr = $this->connector->getData("SELECT * FROM Course", null);
        return $arr;
    }

    function AddCourse($newcourse){
        $this->connector->saveData("INSERT INTO Course (Number) VALUES (?)", array($newcourse));
    }

    function DeleteCourse($oldcourse){
        $this->connector->saveData("DELETE FROM Course WHERE Number = ?", array($oldcourse));
    }

    function ChangeCourse($oldcourse, $newcourse){
        $this->connector->saveData("UPDATE Course SET Number = ? WHERE Number = ?", array($newcourse, $oldcourse));
    }
/*SELECT * FROM `Lesson` WHERE
ID_Day = (SELECT ID FROM `Day` d WHERE d.Name = 'Вторник') AND
ID_Timeplace IN (SELECT ID FROM `Timeplace` t WHERE t.Odd = 0) AND
ID_Group IN (SELECT ID FROM `Groups` g WHERE g.ID_Course = (SELECT ID FROM `Course` c WHERE c.Number = 2))*/

    function GetGroups($course){
        $arr = $this->connector->getData("SELECT * FROM Groups g WHERE g.ID_Course = (SELECT ID FROM Course c WHERE c.Number = ?)", array($course));
        return $arr;
    }
    
    function GetGroup($group, $course){  // Чтобы было полное описание группы
        $arr = $this->connector->getData("SELECT * FROM Groups WHERE Name = ? AND ID_Course = (SELECT ID FROM Course c WHERE c.Number = ?)", array($group, $course));
        return $arr;
    }

    function AddGroup($course, $newgroup){
        $this->connector->saveData("INSERT INTO Groups (Name, ID_Course) VALUES (?, (SELECT ID FROM Course c WHERE c.Number = ?))", array($newgroup, $course));
    }

    function DeleteGroup($course, $oldgroup){
        $this->connector->saveData("DELETE FROM Groups WHERE Name = ? AND ID_Course = (SELECT ID FROM Course c WHERE c.Number = ?)", array($oldgroup, $course));
    }

    function ChangeGroup($course, $oldgroup, $newgroup){
        $this->connector->saveData("UPDATE Groups SET Name = ? WHERE Name = ? AND ID_Course = (SELECT ID FROM Course c WHERE c.Number = ?)", array($newgroup, $oldgroup, $course));
    }

    function ClearAll(){
        $this->connector->saveData("DELETE FROM Lesson WHERE 1", null);
        $this->connector->saveData("DELETE FROM Room WHERE 1", null);
        $this->connector->saveData("DELETE FROM Day WHERE 1", null);
        $this->connector->saveData("DELETE FROM Timeplace WHERE 1", null);
        $this->connector->saveData("DELETE FROM Subject WHERE 1", null);
        $this->connector->saveData("DELETE FROM Groups WHERE 1", null);
        $this->connector->saveData("DELETE FROM Course WHERE 1", null);
    }


    function GetRoomByID($roomid){
        $arr = $this->connector->getData("SELECT * FROM Room WHERE ID = ?", array($roomid));
        return $arr;
    }

    function GetIDByRoom($room){
        $arr = $this->connector->getData("SELECT ID FROM Room WHERE Name = ?", array($room));
        return $arr;
    }

    function GetIDByDay($day){
        $arr = $this->connector->getData("SELECT ID FROM Day WHERE Name = ?", array($day));
        return $arr;
    }

    function GetSubjectByID($subjid){
        $arr = $this->connector->getData("SELECT * FROM Subject WHERE ID = ?", array($subjid));
        return $arr;
    }

    function GetIDByGroup($group){
        $arr = $this->connector->getData("SELECT ID FROM Groups WHERE Name = ?", array($group));
        return $arr;
    }

    function GetIDBySubject($subj){
        $arr = $this->connector->getData("SELECT ID FROM Subject WHERE Name = ?", array($subj));
        return $arr;
    }

    function GetIDByTimeplace($start, $stop, $oddity){
        $arr = $this->connector->getData("SELECT ID FROM Timeplace WHERE Start = ? AND Stop = ? AND Odd = ?", array($start, $stop, $oddity));
        return $arr;
    }

    function TakeSchedule(){
        $arr = $this->connector->getData("SELECT * FROM Lesson WHERE 1", null);
        return $arr;
    }
    
    function GetSchedule($timeid, $course, $group, $day)
    {
        if($group != null){
            $arr = $this->connector->getData("SELECT * FROM Lesson WHERE 
              ID_Day = (SELECT ID FROM Day d WHERE d.Name = ?) 
              AND ID_Timeplace = ?
              AND ID_Group = ?", array($day, $timeid, $group));
        }
        else{
            $arr = $this->connector->getData("SELECT * FROM Lesson WHERE 
              ID_Day = (SELECT ID FROM Day d WHERE d.Name = ?) 
              AND ID_Timeplace = ?
              AND ID_Group IN (SELECT ID FROM Groups g WHERE g.ID_Course = (SELECT ID FROM Course c WHERE c.Number = ?))", array($day, $timeid, $course));
        }
        return $arr;
    }

    function SetSchedule($timeid, $day, $group, $room, $subject)
    {
        $dday = $this->GetIDByDay($day)[0]['ID'];
        $droom = $this->GetIDByRoom($room)[0]['ID'];
        $dsubject = $this->GetIDBySubject($subject)[0]['ID'];

        $this->connector->saveData("INSERT INTO Lesson(ID_Timeplace, ID_Day, ID_Group, ID_Room, ID_Subject) VALUES (?, ?, ?, ?, ?)", array($timeid, $dday, $group, $droom, $dsubject));
        return array($timeid, $dday, $group, $droom, $dsubject);
    }

    function DeleteSchedule($timeid, $day, $group, $room, $subject)
    {
        $dday = $this->GetIDByDay($day)[0]['ID'];
        $droom = $this->GetIDByRoom($room)[0]['ID'];
        $dsubject = $this->GetIDBySubject($subject)[0]['ID'];

        $this->connector->saveData("DELETE FROM Lesson WHERE ID_Timeplace = ? AND ID_Day = ? AND ID_Group = ? AND ID_Room = ? AND ID_Subject = ?", array($timeid, $dday, $group, $droom, $dsubject));
        return array($timeid, $dday, $group, $droom, $dsubject);
    }
    
    function ChangeSchedule($timeid, $day, $group, $room, $subject)
    {
        $dday = $this->GetIDByDay($day)[0]['ID'];
        $droom = $this->GetIDByRoom($room)[0]['ID'];
        $dsubject = $this->GetIDBySubject($subject)[0]['ID'];

        $this->connector->saveData("UPDATE Lesson SET ID_Room = ?, ID_Subject = ? WHERE ID_Timeplace = ? AND ID_Day = ? AND ID_Group = ?", array($droom, $dsubject, $timeid, $dday, $group));
        return array($timeid, $dday, $group, $droom, $dsubject);
    }

    
    
}