<?php
require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../model/Activity.php");
require_once(__DIR__."/../model/ActivityMapper.php");
require_once(__DIR__."/../model/EventMapper.php");
require_once(__DIR__."/../controller/BaseController.php");

class ActivitiesController extends BaseController {
    private ActivityMapper $activityMapper;
    private EventMapper $eventMapper;

    public function __construct() {
        parent::__construct();
        $this->activityMapper = new ActivityMapper();
        $this->eventMapper = new EventMapper();
    }

    public function view() {
        if (!isset($_GET["id"])) {
            $this->view->redirect("events", "index");
        }

        $activityId = (int)$_GET["id"];
        $activity = $this->activityMapper->findById($activityId);

        if ($activity === null) {
            $this->view->redirect("events", "index");
        }

        $event = $this->eventMapper->findById($activity->getEventId());

        $this->view->setVariable("activity", $activity);
        $this->view->setVariable("event", $event);
        $this->view->render("activities", "view");
    }

    public function add() {
        if (!isset($this->currentUser)) {
            $this->view->setFlash(i18n("You must be logged in to add activities"));
            $this->view->redirect("users", "login");
        }

        if (!isset($_REQUEST["event_id"])) {
            $this->view->redirect("events", "index");
        }

        $eventId = (int)$_REQUEST["event_id"];
        $event = $this->eventMapper->findById($eventId);

        if ($event === null) {
            $this->view->redirect("events", "index");
        }

        if ($event->getUserId() !== $this->currentUser->getId()) {
            $this->view->setFlash(i18n("You are not authorized to add activities to this event"));
            $this->view->redirect("events", "view", "id=".$eventId);
        }

        $activity = new Activity();
        $activity->setEventId($eventId);

        if (isset($_POST["title"])) {
            $activity->setTitle($_POST["title"]);
            $activity->setDescription($_POST["description"]);
            $activity->setStartTime($_POST["start_time"]);
            $activity->setEndTime($_POST["end_time"]);
            $activity->setSpeaker($_POST["speaker"] ?? null);

            try {
                $activity->checkIsValidForCreate();
                $this->activityMapper->save($activity);

                $this->view->setFlash(i18n("Activity successfully added."));
                $this->view->redirect("events", "view", "id=".$eventId);
            } catch (ValidationException $ex) {
                $this->view->setVariable("errors", $ex->getErrors());
            }
        }

        $this->view->setVariable("activity", $activity);
        $this->view->setVariable("event", $event);
        $this->view->render("activities", "add");
    }

    public function edit() {
        if (!isset($this->currentUser)) {
            $this->view->setFlash(i18n("You must be logged in to edit activities"));
            $this->view->redirect("users", "login");
        }

        if (!isset($_REQUEST["id"])) {
            $this->view->redirect("events", "index");
        }

        $activityId = (int)$_REQUEST["id"];
        $activity = $this->activityMapper->findById($activityId);

        if ($activity === null) {
            $this->view->redirect("events", "index");
        }

        $event = $this->eventMapper->findById($activity->getEventId());

        if ($event->getUserId() !== $this->currentUser->getId()) {
            $this->view->setFlash(i18n("You are not authorized to edit activities of this event"));
            $this->view->redirect("events", "view", "id=".$event->getId());
        }

        if (isset($_POST["title"])) {
            $activity->setTitle($_POST["title"]);
            $activity->setDescription($_POST["description"]);
            $activity->setStartTime($_POST["start_time"]);
            $activity->setEndTime($_POST["end_time"]);
            $activity->setSpeaker($_POST["speaker"] ?? null);

            try {
                $activity->checkIsValidForCreate();
                $this->activityMapper->update($activity);

                $this->view->setFlash(i18n("Activity successfully updated."));
                $this->view->redirect("events", "view", "id=".$event->getId());
            } catch (ValidationException $ex) {
                $this->view->setVariable("errors", $ex->getErrors());
            }
        }

        $this->view->setVariable("activity", $activity);
        $this->view->setVariable("event", $event);
        $this->view->render("activities", "edit");
    }

    public function delete() {
        if (!isset($this->currentUser)) {
            $this->view->setFlash(i18n("You must be logged in to delete activities"));
            $this->view->redirect("users", "login");
        }

        if (isset($_POST["id"])) {
            $activityId = (int)$_POST["id"];
            $activity = $this->activityMapper->findById($activityId);

            if ($activity !== null) {
                $event = $this->eventMapper->findById($activity->getEventId());
                if ($event !== null && $event->getUserId() === $this->currentUser->getId()) {
                    $this->activityMapper->delete($activity);
                    $this->view->setFlash(i18n("Activity successfully deleted."));
                    $this->view->redirect("events", "view", "id=".$event->getId());
                } else {
                    $this->view->setFlash(i18n("You are not authorized to delete this activity"));
                    $this->view->redirect("events", "index");
                }
            }
        }

        $this->view->redirect("events", "index");
    }
}
