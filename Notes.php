<?php 

use Utopia\App;
use Utopia\Exception;
use Utopia\Response;
use Utopia\Config\Config;
use CRUDJson;

$db = new CRUDJson();
// New Note - add new Note
// @param : Note Id, User Id, Content
// @return JSON of new Note
App::post('/v1/notes')
	   ->desc('New Note')
	   ->param('note_id', null, function () { return new Text(100); }, 'Note ID.')
	   ->param('user_id', null, function () { return new Text(100); }, 'User ID.')
       ->param('content', null, function () { return new Text(512); }, 'Note Content.')
       ->action(
       		function ($note_id, $content,$user_id) use ($response,$db) {
       			$document = $db->setDocument($note_id,$user_id,$content);
       			if ($document != NULL){
       				$response
                		->setStatusCode(Response::STATUS_CODE_CREATED)
                		->json($document);
       			} else {
       				throw new Exception('Failed creating note to DB', 500);
       			}
       		}
       );

// Get All Notes 
// @return JSON of all Notes
App::get('/v1/notes')
    ->desc('List Notes')
    ->action(
    	function () use ($response,$db) {
       			$document = $db->getAll();
       			if ($document != NULL){
       				$response
                		->setStatusCode(Response::STATUS_CODE_CREATED)
                		->json($document);
       			} else {
       				throw new Exception('Failed getting notes', 500);
       			}
       	}

    );
// Get Note by Note ID 
// @param : Note Id
// @return JSON of specific Note
App::get('/v1/note/:note_id')
    ->desc('Get note content')
    ->param('note_id', null, function () { return new Text(100); }, 'Note ID.')
    ->action(
    	function ($note_id) use ($response,$db) {
       			$document = $db->getDocument();
       			if ($document != NULL){
       				$response
                		->setStatusCode(Response::STATUS_CODE_CREATED)
                		->json($document);
       			} else {
       				throw new Exception('Note not found', 404);
       			}
       	}
    );
// Update Note Content
// @param : Note ID
// @return JSON of specific Note
App::put('/v1/notes/:note_id')
    ->desc('Update note')
    ->param('note_id', null, function () { return new Text(100); }, 'Note ID.')
    ->param('content', null, function () { return new Text(512); }, 'Note new Content.')
    ->action(
      function ($note_id,$content) use ($response,$db) {
        $json = updateDocument($note_id, $content);
        if ($json == NULL) {
          throw new Exception('Note not found', 404);
        } else {
          $response->json($json);
        }

      }

    );

// Delete Note
// @param : Note ID
// @return JSON of deleted Note
App::delete('/v1/notes/:note_id')
    ->desc('Delete note')
    ->param('note_id', null, function () { return new Text(100); }, 'Note ID to delete.')
    ->action(
      function ($note_id) use ($response,$db) {
        $json = deleteDocument($note_id);
        if ($json == NULL) {
          throw new Exception('Note not found', 404);
        } else {
          $response->json($json);
        }
    );


?>