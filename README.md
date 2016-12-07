#NotifyException for PHP
A PHP Exception Handler to Post Exceptions to a messaging app channel like Slack.


##Currently supported messaging app
 - Slack (slack.com)
 - RocketChat (rocket.chat)
 
##Installation
Install with composer

    composer require slaveofcode/notifyexception
    
Then you can set the configuration on your startup or index file. `NotifyException` needs configuration set based on constants like this.

    // Example Configuration
    define('NOTIFY_EXCEPTION_SLACK', [
        'webhook' => 'https://hooks.slack.com/services/YOUR/SLACK/WEBHOOK',
        'channel' => 'my_awesome_channel',
        'username' => 'Taylor Swift' // optional
    ]);
    
    define('NOTIFY_EXCEPTION_ROCKETCHAT', [
        'webhook' => 'http://chat.myserver.com/hooks/HOOK_CODE/HOOK_CODE',
        // add attachment, all the options below is optional
        'title' => 'CRM ROBOT',
        'title_link' => 'http://crm2.jobs.id', 
        'image_url' => 'http://i.imgur.com/wJAmxZ9.jpg'
    ]);

Then you can extends the Notify class by define your own class like this

    class MyExceptionClass extends NotifyException
    {
        /* Here you can override the message to fit your needs */
        protected function getTraceMessage()
        {
            $basicMessage = parent::getTraceMessage();
            
            // You also can append your custom message here
            $customMessage = <<<EOD
            Account: Budi
            LOCATION: http://lalala.com
            EOD;
    
            return $basicMessage . $customMessage;
        }
    }
    
Then you can use your custom exception like code below, and where the error raised it will be notify to messaging service.

    try {
        throw new MyExceptionClass('Hei you got error...bla bla...');
    } catch (MyExceptionClass $e) {
        echo $e->getMessage();
    // It is recommended to add your last Exception class on last catch, believe me it save your day
    } catch (\Exception $e) {
        echo $e->getMessage();
    }