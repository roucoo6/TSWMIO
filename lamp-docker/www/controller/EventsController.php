<?php
require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../model/Event.php");
require_once(__DIR__."/../model/EventMapper.php");
require_once(__DIR__."/../model/ActivityMapper.php");
require_once(__DIR__."/../controller/BaseController.php");

class EventsController extends BaseController {
    private EventMapper $eventMapper;
    private ActivityMapper $activityMapper;

    public function __construct() {
        parent::__construct();
        $this->eventMapper = new EventMapper();
        $this->activityMapper = new ActivityMapper();
    }

    public function index() {
        $events = $this->eventMapper->findAll();
        $this->view->setVariable("events", $events);
        $this->view->render("events", "index");
    }

    public function view() {
        if (!isset($_GET["id"])) {
            $this->view->redirect("events", "index");
        }

        $eventId = (int)$_GET["id"];
        $event = $this->eventMapper->findById($eventId);

        if ($event === null) {
            $this->view->redirect("events", "index");
        }

        $activities = $this->activityMapper->findByEventId($eventId);
        $event->setActivities($activities);

        $this->view->setVariable("event", $event);
        $this->view->render("events", "view");
    }

    public function add() {
        if (!isset($this->currentUser)) {
            $this->view->setFlash(i18n("You must be logged in to create events"));
            $this->view->redirect("users", "login");
        }

        $event = new Event();

        if (isset($_POST["title"])) {
            $event->setTitle($_POST["title"]);
            $event->setDescription($_POST["description"]);
            $event->setDate($_POST["date"]);
            $event->setLocation($_POST["location"]);
            $event->setImage(!empty($_POST["image"]) ? $_POST["image"] : "default_event.jpg");
            $event->setUserId($this->currentUser->getId());

            try {
                $event->checkIsValidForCreate();
                $eventId = $this->eventMapper->save($event);

                $this->view->setFlash(i18n("Event successfully created."));
                $this->view->redirect("events", "view", "id=".$eventId);
            } catch (ValidationException $ex) {
                $this->view->setVariable("errors", $ex->getErrors());
            }
        }

        $this->view->setVariable("event", $event);
        $this->view->render("events", "add");
    }

  public function edit() {
        if (!isset($this->currentUser)) {
            $this->view->setFlash(i18n("You must be logged in to edit events"));
            $this->view->redirect("users", "login");
        }

        if (!isset($_REQUEST["id"])) {
            $this->view->redirect("events", "index");
        }

        $eventId = (int)$_REQUEST["id"];
        $event = $this->eventMapper->findById($eventId);

        if ($event === null) {
            $this->view->redirect("events", "index");
        }

        // Comprobación de autoría: el ID del usuario en sesión debe coincidir con el user_id del evento
        if ($event->getUserId() !== $this->currentUser->getId()) {
            $this->view->setFlash(i18n("You are not authorized to edit this event"));
            $this->view->redirect("events", "view", "id=".$eventId);
        }

        if (isset($_POST["title"])) {
            $event->setTitle($_POST["title"]);
            $event->setDescription($_POST["description"]);
            $event->setDate($_POST["date"]);
            $event->setLocation($_POST["location"]);
            if (!empty($_POST["image"])) {
                $event->setImage($_POST["image"]);
            }

            try {
                $event->checkIsValidForCreate();
                $this->eventMapper->update($event);

                // Patrón PRG: Redirección tras POST exitoso con mensaje flash
                $this->view->setFlash(i18n("Event successfully updated."));
                $this->view->redirect("events", "view", "id=".$eventId);
            } catch (ValidationException $ex) {
                $this->view->setVariable("errors", $ex->getErrors());
            }
        }

        $this->view->setVariable("event", $event);
        $this->view->render("events", "edit");
    }

    public function delete() {
        if (!isset($this->currentUser)) {
            $this->view->setFlash(i18n("You must be logged in to delete events"));
            $this->view->redirect("users", "login");
        }

        if (isset($_POST["id"])) {
            $eventId = (int)$_POST["id"];
            $event = $this->eventMapper->findById($eventId);

            // Comprobación de autoría: solo se borra si existe y si el ID coincide exactamente
            if ($event !== null && $event->getUserId() === $this->currentUser->getId()) {
                $this->eventMapper->delete($event);
                $this->view->setFlash(i18n("Event successfully deleted."));
            } else {
                $this->view->setFlash(i18n("You are not authorized to delete this event"));
            }
        }

        $this->view->redirect("events", "index");
    }
}
