module.exports = function (grunt) {

	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-contrib-copy');

	grunt.initConfig({
		less : {
			dev: {
				files: {
					'css/main.css': 'less/main.less'
				}
			},
			build: {
				options: {
					cleancss: true
				},
				files: {
					'build/css/main.css': 'less/main.less'
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
					{ src: '*.html', dest: 'build/' }
				]
			},
			less_dev: {
				files: [
					{ src: 'css/main.css', dest: '../kbiwp/wp-content/themes/kasparabi/assets/css/main.css' }
				]
			}
		},

		delta: {
			options: {
				livereload: true
			},

			less: {
				files: 'less/**/*.less',
				tasks: ['clean:css', 'less:dev', 'copy:less_dev']
			},

			html: {
				files: '**/*.html'
			},

			php: {
				files: '../**/*.php'
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