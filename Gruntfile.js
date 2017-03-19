'use strict';

module.exports = function(grunt) {
    require('load-grunt-tasks')(grunt);
    if(grunt.option('account-id') === undefined){
        return grunt.fail.fatal('--account-id is required', 1);
    }

    var path = require('path');
    grunt.initConfig({
        lambda_deploy: {
            patronService: {
                package: 'patronService',
                options: {
                    file_name: 'index.js',
                    handler: 'handler',
                },
                arn: 'arn:aws:lambda:us-east-1:' + grunt.option('account-id') + ':function:patronService',
            }
        },
        lambda_package: {
            patronService: {
                package: 'patronService',
            }
        },
        env: {
            prod: {
                NODE_ENV: 'production',
            },
        },

    });


    grunt.registerTask('deploy', ['env:prod', 'lambda_package:patronService', 'lambda_deploy:patronService']);
};
