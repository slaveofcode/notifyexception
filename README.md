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
    define('NOTIFY_EXCEPTION_SLACK', serialize([
        'webhook' => 'https://hooks.slack.com/services/YOUR/SLACK/WEBHOOK',
        'channel' => 'my_awesome_channel',
        'username' => 'Taylor Swift' // optional
    ]));
    
    define('NOTIFY_EXCEPTION_ROCKETCHAT', serialize([
        'webhook' => 'http://chat.myserver.com/hooks/HOOK_CODE/HOOK_CODE',
        // add attachment, all the options below are optional
        'title' => 'CRM ROBOT',
        'title_link' => 'http://crm2.jobs.id', 
        'image_url' => 'http://i.imgur.com/wJAmxZ9.jpg'
    ]));

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
    
And you can use your custom exception like code below, and where the error raised it will be notify to messaging service.

    try {
        throw new MyExceptionClass('Hei you got error...bla bla...');
    } catch (MyExceptionClass $e) {
        echo $e->getMessage();
    // It is recommended to add your last Exception class on last catch, believe me it save your day
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
    
#Improvements & Updates
Any request for improvements or updates please open the issue on this project.

# License
The MIT License (MIT)

Copyright (c) 2016 Aditya Kresna Permana

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.