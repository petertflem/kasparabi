module.exports = function (grunt) {

	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-contrib-copy');

	grunt.initConfig({
		less : {
			dev: {
				files: {
					'stylesheets/css/main.css': 'stylesheets/less/main.less'
				}
			},
			build: {
				options: {
					cleancss: true
				},
				files: {
					'build/css/main.css': 'stylesheets/less/main.less'
				}
			}
		},

		clean: {
			css: ['css/main.css'],
			build: ['build/*']
		},

		copy: {
			build: {
				files: [
					{ src: 'index.html', dest: 'build/' }
				]
			}
		},

		delta: {
			options: {
				livereload: true
			},

			less: {
				files: 'stylesheets/less/**/*.less',
				tasks: ['clean:css', 'less:dev']
			},

			html: {
				files: '**/*.html'
			}
		}
	});

	grunt.renameTask('watch', 'delta');

	grunt.registerTask('watch', ['delta']);
	grunt.registerTask('build', [
		'clean:build',	// delete the previous build folder
		'less:build',	// compile less into build/css/
		'copy:build'	// copy the other needed files into the build folder (.html ...)
	]);
}