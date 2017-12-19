Contributing to Tecnocen Yii2 Workflow
======================================

:+1::tada: First off, thanks for taking the time to contribute! :tada::+1:

The following is a set of guidelines for contributing to Tecnocen and its
packages, which are hosted in the
[Tecnocen Organization](https://github.com/tecnocen-com) on GitHub. These
are mostly guidelines, not rules. Use your best judgment, and feel free to
propose changes to this document in a pull request.

Forums and Support
------------------

We are currently piggy backing from
[Yii2 Extensions Forum](http://www.yiiframework.com/forum/index.php/forum/13-extensions/)
you can make questions there where other Yii2 devs might see it and answer it.
 
If you need profesional support please feel free to contact support@tecnocen.com with the following information.

- What steps will reproduce the problem?
- What is the expected result?
- What do you get instead?
- Additional info


Reporting Bugs
--------------

Bugs are tracked as [GitHub issues](https://guides.github.com/features/issues/).
Its required for you to follow this steps when submitting a bug:

1. Determine its not already reported by searching existing issues
   https://github.com/search?q=+is%3Aissue+user%3Atecnocen-com

2. Determine its not an issue of any of the dependencies of this library such as
   [Yii2](https://github.com/search?q=+is%3Aissue+user%3Ayiisoft)

3. If the bug has not been reported then provide enough information to reproduce
   and isolate the bug.
   - Use a descriptive title to differentiate the bug.
   - Describe the exact steps to reproduce the issue. Focus on how you did it
     instead of what you did.
   - Provide specific examples to demonstrate the steps. You can upload files,
     screen captures, links to copy/paste snippets, etc.
   - Describe observed behavior.
   - Describe expected behavior.
   - If you report a server error caused by the library include the error
     message you get along with the exception trace if you have it.
   - Provide the versions used by composer using the comand
     > composer show

4. Stay in touch, check the issue for feedback from other users and developers.

Suggesting Enhancements
-----------------------

You can suggest enhancements for the library using Github Issues aswell. Its
required for you to follow this steps when suggesting a change.

1. Read the documentation and see if the enhancement does not exists already.

2. Check the description of the library and see if there are use cases for your
   enhacement into the library.

3. Check if there is not a package already which covers the use case described
   on the previous step.

4. Check it was not already suggested
   https://github.com/search?q=+is%3Aissue+user%3Atecnocen-com

5. If the enhancement was not suggested already then provide enough information
   to understand and develop the enhacenment
   - Use a descriptive title to differentiate the enhancement.
   - Describe the exact steps to utilize the enhancement. Focus on how you plant
     to use it and implement instead on what you want implemented.
   - Provide specific examples to demonstrate the steps. You can upload files,
     screen captures, links to copy/paste snippets, etc.
   - Describe expected behavior.

Code Contribution
-----------------

Code contributions are handled by Github Pull Requests.

### Testing Environment

This library contains tools to set up a testing environment using composer
scripts.
P
- Clone the repository from github and move to the created folder.
- edit or create the file `tests/_app/config/db.local.php` with your db
  credentials
- Prepare your local environment to run the tests with composer script
  > composer deploy-tests
- When the command finish executing successfully you can run
  `composer run-tests` to run all the codeception tests of the library.

You can now write changes locally and run tests to change

Creating Pull Requests
----------------------

When you are ready to submit your contribution you can create a pull request.
Its required for you to follow this steps when creating a pull request.

1. Use a descriptive title, include the issues and pull request #id the new 
   pull request affects on the tile.
2. Describe the use case or bug it covers, keep it simple by focusing on one
   functionality at once.
