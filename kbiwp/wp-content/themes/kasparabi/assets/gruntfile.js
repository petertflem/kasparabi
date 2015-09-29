module.exports = function (grunt) {

	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-contrib-concat');

	grunt.initConfig({
		less : {
			dev: {
				files: {
					'css/custom.css': 'less/main.less'
				}
			}
		},

		concat: {
			css: {
				src: ['css/vendor/bootstrap.min.css', 'css/custom.css'],
				dest: 'css/main.css'
			}
		},

		clean: {
			css: ['css/main.css'],
			temp: ['css/custom.css']
		},

		delta: {
			options: {
				livereload: true
			},

			less: {
				files: 'less/**/*.less',
				tasks: ['clean:css', 'less:dev', 'concat:css', 'clean:temp']
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
}
