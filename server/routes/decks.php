<?php

$this->group('/decks', function () {
    $this->get('', function ($request, $response) {
        $decks = Controllers\Decks::getAll();
        $json = Controllers\Decks::toJson($decks);
        return $response->withStatus(200)->getBody()->write($json);
    });

    $this->post('', function ($request, $response) {
        $deck = Controllers\Decks::addNewDeck([
            'title' => $request->getParam('title'),
            'description' => $request->getParam('description'),
            'useSpell' => $request->getParam('useSpell'),
            'frontSpell' => $request->getParam('frontSpell'),
            'backSpell' => $request->getParam('backSpell')
        ]);
        $decks = Controllers\Decks::getAll();
        $json = Controllers\Decks::toJson($decks);
        return $response->withStatus(201)->getBody()->write($json);
    });

    $this->get('/{deckId}', function ($request, $response, $args) {
        $deck = Controllers\Decks::getById($request->getAttribute('deckId'));
        $json = Controllers\Decks::toJson($deck);
        return $response->withStatus(200)->getBody()->write($json);
    });

    $this->put('/{deckId}', function ($request, $response) {
        $deck = Controllers\Decks::updateDeck($request->getAttribute('deckId') ,[
            'title' => $request->getParam('title'),
            'description' => $request->getParam('description'),
            'useSpell' => $request->getParam('useSpell'),
            'frontSpell' => $request->getParam('frontSpell'),
            'backSpell' => $request->getParam('backSpell')
        ]);
        $decks = Controllers\Decks::getAll();
        $json = Controllers\Decks::toJson($decks);
        return $response->withStatus(201)->getBody()->write($json);
    });

    $this->delete('/{deckId}', function ($request, $response, $args) {
        $deck = Controllers\Decks::deleteById($request->getAttribute('deckId'));
        $decks = Controllers\Decks::getAll();
        $json = Controllers\Decks::toJson($decks);
        return $response->withStatus(200)->getBody()->write($json);
    });

    $this->group('/{deckId}/cards', function () {
        $this->get('', function ($request, $response) {
            $deck = Controllers\Decks::getById($request->getAttribute('deckId'));
            $json = Controllers\Decks::toJson($deck->cards);
            return $response->withStatus(200)->getBody()->write($json);
        });

        $this->post('', function ($request, $response, $args) {
            Controllers\Decks::addNewCard($request->getAttribute('deckId'), [
                'front' => $request->getParam('front'),
                'back' => $request->getParam('back'),
                'note' => $request->getParam('note'),
                'icon' => $request->getParam('icon'),
                'resourceUrl' => $request->getParam('resourceUrl')
            ]);
            $deck = Controllers\Decks::getById($request->getAttribute('deckId'));
            $json = Controllers\Decks::toJson($deck->cards);
            return $response->withStatus(201)->getBody()->write($json);
        });

        $this->put('/{cardId}', function ($request, $response, $args) {
            $card = Controllers\Cards::updateCard($request->getAttribute('cardId'), [
                'front' => $request->getParam('front'),
                'back' => $request->getParam('back'),
                'note' => $request->getParam('note'),
                'icon' => $request->getParam('icon'),
                'resourceUrl' => $request->getParam('resourceUrl')
            ]);
            $deck = Controllers\Decks::getById($request->getAttribute('deckId'));
            $json = Controllers\Decks::toJson($deck->cards);
            return $response->withStatus(200)->getBody()->write($json);
        });

        $this->delete('/{cardId}', function ($request, $response) {
            $card = Controllers\Cards::deleteById($request->getAttribute('cardId'));
            $deck = Controllers\Decks::getById($request->getAttribute('deckId'));
            $json = Controllers\Decks::toJson($deck->cards);
            return $response->withStatus(200)->getBody()->write($json);
        });

    });
});
