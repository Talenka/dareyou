<?php
/**
 * Display last prizes won by users, with prize details
 *
 * @todo implement it then cache results for an hour
 */

namespace Dareyou;

require_once 'core.php';

sendPageToClient(L('Prized won by users'), h2(L('Prized won by users')));
