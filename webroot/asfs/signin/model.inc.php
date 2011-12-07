<?php

class Model {
	
	private $mongo;
	private $mongoDb;
	
	public function Model() {
		$this->mongo = new Mongo(MONGO_CONNECTION);
		$this->mongoDb = $this->mongo->asfs;
	}

	/**
	 * @return the new entry, TODO return null if fail
	 */
	public function visitorSignIn($school, $name, $purpose, $notes) {
		dbglog("Adding visitor sign-in entry...");
		$entry = new VisitorEntry($school, $name, $purpose, $notes);
		$collection = $this->mongoDb->selectCollection("visit");
		$entry->entryTime = time();
		$entry->name = strtolower($entry->name);
		$entry->child = strtolower($entry->child);
		$collection->insert($entry);
		return (array)$entry;
	}

	public function visitorSignOut($entryId) {
		dbglog("Adding signout to entry...");
		$collection = $this->mongoDb->selectCollection("visit");
		$entry->entryTime = time();
		$queryParams = array("_id" => new MongoId($entryId));
		$obj = $collection->findOne($queryParams);
		if (isset($obj)) {
			dbglog("About to update entry...");
			$collection->update($queryParams, array(
				'$set' => array(
					"exitTime" => time()
				)
			));
		} else {
			dbglog("Couldn't sign out of entry; not found");
			return false;
		}
		return true;
	}

	public function deleteEntry($entryId) {
		dbglog("Deleting entry " . $entryId);
		$collection = $this->mongoDb->selectCollection("visit");
		$queryParams = array("_id" => new MongoId($entryId));
		$collection->remove($queryParams);
		return true;
	}

	public function getEntry($entryId) {
		dbglog("Retrieving entry " . $entryId);
		$collection = $this->mongoDb->selectCollection("visit");
		$queryParams = array("_id" => new MongoId($entryId));
		return $collection->findOne($queryParams);
	}

	/** 
	 * @date YYYY-MM-DD
	 */
	function getEntriesForDate($date, $type = "all") {
		$firstEntryTime = strtotime($date);
		$lastEntryTime = $firstEntryTime + (60*60*24);
		dbglog("Getting all entries back to " . $firstEntryTime);
		$collection = $this->mongoDb->selectCollection("visit");
		$queryParams = array("entryTime" => array('$gt' => $firstEntryTime, '$lt' => $lastEntryTime));
		if ($type == "open") {
			$queryParams["exitTime"] = -1;
		} else if ($type == "closed") {
			$queryParams["exitTime"] = array('$ne' => -1);
		} 
		$cursor = $collection->find($queryParams);
		return $cursor;
	}

	/** 
	 */
	function searchEntries($text) {
		$text = strtolower($text);
		dbglog("Searching for entries matching '" . $text . "'");
		$collection = $this->mongoDb->selectCollection("visit");
		$queryParams = array("name" => array('$regex' => $text));
		$cursor = $collection->find($queryParams);
		dbglog("Located " . $cursor->count() . " entries matching '" . $text . "'");
		return $cursor;
	}
	
}

class VisitorEntry {
	
	public $school;
	public $name;
	public $purpose;
	public $notes;
	public $entryTime;
	public $exitTime;

	public function VisitorEntry($school, $name, $purpose, $notes) {
		$this->school = $school;
		$this->name = $name;
		$this->purpose = $purpose;
		$this->notes = $notes;
		$this->entryTime = -1;
		$this->exitTime = -1;
	}
	
}

?>
