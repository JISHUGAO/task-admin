@servers(['localhost' => ['127.0.0.1']])

@story('deploy')
    git
    composer
@endstory

@task('git')
    git pull origin master
@endtask

@task('composer')
    composer update
@endtask