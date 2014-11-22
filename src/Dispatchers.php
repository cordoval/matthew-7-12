<?php

namespace Grace;

class Dispatchers
{
    const READ = 'read_event_dispatcher';
    const READ_LISTENER = 'read_event_dispatcher_listener';
    const READ_SUBSCRIBER = 'read_event_dispatcher_subscriber';

    const WRITE = 'write_event_dispatcher';
    const WRITE_LISTENER = 'write_event_dispatcher_listener';
    const WRITE_SUBSCRIBER = 'write_event_dispatcher_subscriber';
}