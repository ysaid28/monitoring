<?php
/**
 * Created by IntelliJ IDEA.
 * User: UPro
 * Date: 03/06/2018
 * Time: 23:21
 */

namespace App\Service;


class UrlTester
{

    /**
     * @param null|string $code
     * @return array
     */
    public static function getHTTPResponseCode(?string $code): array
    {
        switch ($code) {
            case 100:
                $text = 'Continue';
                $message = 'Attente de la suite de la requête.';
                break;
            case 101:
                $text = 'Switching Protocols';
                $message = 'Acceptation du changement de protocole.';
                break;
            case 200:
                $text = 'OK';
                $message = 'Requête traitée avec succès.';
                break;
            case 201:
                $text = 'Created';
                $message = 'Requête traitée avec succès et création d’un document.';
                break;
            case 202:
                $text = 'Accepted';
                $message = 'Requête traitée, mais sans garantie de résultat.';
                break;
            case 203:
                $text = 'Non-Authoritative Information';
                $message = 'Information retournée, mais générée par une source non certifiée.';
                break;
            case 204:
                $text = 'No Content';
                $message = 'Requête traitée avec succès mais pas d’information à renvoyer.';
                break;
            case 205:
                $text = 'Reset Content';
                $message = 'Requête traitée avec succès, la page courante peut être effacée.';
                break;
            case 206:
                $text = 'Partial Content';
                $message = 'Une partie seulement de la ressource a été transmise.';
                break;
            case 300:
                $text = 'Multiple Choices';
                $message = 'L’URI demandée se rapporte à plusieurs ressources.';
                break;
            case 301:
                $text = 'Moved Permanently';
                $message = 'Document déplacé de façon permanente.';
                break;
            case 302:
                $text = 'Moved Temporarily';
                $message = 'Document déplacé de façon temporaire.';
                break;
            case 303:
                $text = 'See Other';
                $message = 'La réponse à cette requête est ailleurs.';
                break;
            case 304:
                $text = 'Not Modified';
                $message = 'Document non modifié depuis la dernière requête.';
                break;
            case 305:
                $text = 'Use Proxy';
                $message = 'La requête doit être ré-adressée au proxy.';
                break;
            case 400:
                $text = 'Bad Request';
                $message = 'La syntaxe de la requête est erronée.';
                break;
            case 401:
                $text = 'Unauthorized';
                $message = 'Une authentification est nécessaire pour accéder à la ressource.';
                break;
            case 402:
                $text = 'Payment Required';
                $message = 'Le serveur a compris la requête, mais refuse de l\'exécuter. Contrairement à l\'erreur 401, s\'authentifier ne fera aucune différence. Sur les serveurs où l\'authentification est requise, cela signifie généralement que l\'authentification a été acceptée mais que les droits d\'accès ne permettent pas au client d\'accéder à la ressource.';
                break;
            case 403:
                $text = 'Forbidden';
                $message = 'Forbidden';
                break;
            case 404:
                $text = 'Not Found';
                $message = 'Ressource non trouvée.';
                break;
            case 405:
                $text = 'Method Not Allowed';
                $message = 'Méthode de requête non autorisée.';
                break;
            case 406:
                $text = 'Not Acceptable';
                $message = 'La ressource demandée n\'est pas disponible dans un format qui respecterait les en-têtes "Accept" de la requête.';
                break;
            case 407:
                $text = 'Proxy Authentication Required';
                $message = 'Accès à la ressource autorisé par identification avec le proxy.';
                break;
            case 408:
                $text = 'Request Time-out';
                $message = 'Temps d’attente d’une requête du client, écoulé côté serveur. D\'après les spécifications HTTP: "Le client n\'a pas produit de requête dans le délai que le serveur était prêt à attendre. Le client PEUT répéter la demande sans modifications à tout moment ultérieur."';
                break;
            case 409:
                $text = 'Conflict';
                $message = 'La requête ne peut être traitée en l’état actuel.';
                break;
            case 410:
                $text = 'Gone';
                $message = 'La ressource n\'est plus disponible et aucune adresse de redirection n’est connue.';
                break;
            case 411:
                $text = 'Length Required';
                $message = 'La longueur de la requête n’a pas été précisée.';
                break;
            case 412:
                $text = 'Precondition Failed';
                $message = 'Préconditions envoyées par la requête non vérifiées.';
                break;
            case 413:
                $text = 'Request Entity Too Large';
                $message = 'Traitement abandonné dû à une requête trop importante.';
                break;
            case 414:
                $text = 'Request-URI Too Large';
                $message = 'URI trop longue.';
                break;
            case 415:
                $text = 'Unsupported Media Type';
                $message = 'Format de requête non supporté pour une méthode et une ressource données.';
                break;
            case 416:
                $text = 'Requested Range Not Satisfiable';
                $message = 'Champs d’en-tête de requête « range » incorrect.';
                break;
            case 417:
                $text = 'Execption Failed';
                $message = 'Comportement attendu et défini dans l’en-tête de la requête insatisfaisante.';
                break;
            case 418:
                $text = 'IM a Teapot';
                $message = '« Je suis une théière ». Ce code est défini dans la RFC 23247 datée du premier avril 1998, Hyper Text Coffee Pot Control Protocol.';
                break;
            case 500:
                $text = 'Internal Server Error';
                $message = 'Erreur interne du serveur.';
                break;
            case 501:
                $text = 'Not Implemented';
                $message = 'Fonctionnalité réclamée non supportée par le serveur.';
                break;
            case 502:
                $text = 'Bad Gateway';
                $message = 'En agissant en tant que serveur proxy ou passerelle, le serveur à reçu une réponse invalide depuis le serveur distant.';
                break;
            case 503:
                $text = 'Service Unavailable';
                $message = 'Service temporairement indisponible ou en maintenance.';
                break;
            case 504:
                $text = 'Gateway Time-out';
                $message = 'Temps d’attente d’une réponse d’un serveur à un serveur intermédiaire écoulé.';
                break;
            case 505:
                $text = 'HTTP Version not supported';
                $message = 'Version HTTP non gérée par le serveur.';
                break;
            default:
                $text = 'Unknown http status code "' . $code;
                $message = 'Unknown http status code "' . htmlentities($code);
                break;
        }

        return ['text' => $text, 'message' => $message];
    }

    public function httpStatusCode(string $url, ?string $host)
    {
        $c = curl_init($url);
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_NOBODY, true);
        curl_setopt($c, CURLOPT_TIMEOUT, 3);

        curl_exec($c);

        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
        if (!empty($host)) {
            curl_setopt($c, CURLOPT_HTTPHEADER, ['Host: ' . $host]);
        }

        $httpCode = curl_getinfo($c, CURLINFO_HTTP_CODE);
        curl_close($c);
        return $httpCode;
    }

}