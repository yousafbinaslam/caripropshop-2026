import React, { useState } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { Clipboard, Users, Calendar, Target, BarChart3, CheckCircle, Send, Phone, Mail, ArrowLeft, Clock, DollarSign } from 'lucide-react';
import { sendAutomatedResponse } from '../utils/emailService';
import Header from './Header';

const ProjectManagement: React.FC = () => {
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    phone: '',
    projectType: '',
    projectSize: '',
    timeline: '',
    currentStage: '',
    challenges: '',
    message: ''
  });
  const [isSubmitted, setIsSubmitted] = useState(false);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    
    // Send automated response and admin notification
    sendAutomatedResponse({
      name: formData.name,
      email: formData.email,
      phone: formData.phone,
      formType: 'Project Management Consultation',
      projectType: formData.projectType,
      projectSize: formData.projectSize,
      timeline: formData.timeline,
      currentStage: formData.currentStage,
      challenges: formData.challenges,
      message: formData.message
    });
    
    // Show success message
    setIsSubmitted(true);
    setTimeout(() => setIsSubmitted(false), 3000);
    setFormData({
      name: '',
      email: '',
      phone: '',
      projectType: '',
      projectSize: '',
      timeline: '',
      currentStage: '',
      challenges: '',
      message: ''
    });
  };

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value
    });
  };

  return (
    <div className="min-h-screen bg-gray-50">
      <Header />
      <div className="pt-20">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="py-20">
            {/* Back Navigation */}
            <motion.div
              initial={{ opacity: 0, x: -20 }}
              animate={{ opacity: 1, x: 0 }}
              className="mb-8"
            >
              <Link to="/" className="flex items-center text-amber-600 hover:text-amber-700 transition-colors">
                <ArrowLeft className="w-5 h-5 mr-2" />
                Back to Home
              </Link>
            </motion.div>

            {/* Hero Section */}
            <motion.div
              initial={{ opacity: 0, y: 30 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.8 }}
              className="text-center mb-16"
            >
          <div className="flex justify-center mb-6">
            <div className="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
              <Clipboard className="w-10 h-10 text-white" />
            </div>
          </div>
          <h1 className="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
            Expert Project Management
          </h1>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Ensure your interior design project runs smoothly from start to finish with our comprehensive 
            project management services. We coordinate every detail so you can focus on your vision.
          </p>
        </motion.div>

        {/* Services Overview */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.2 }}
          className="grid md:grid-cols-3 gap-8 mb-16"
        >
          {[
            {
              icon: Calendar,
              title: 'Timeline Management',
              description: 'Detailed scheduling and milestone tracking to keep your project on schedule',
              features: ['Project scheduling', 'Milestone tracking', 'Deadline management', 'Progress reporting']
            },
            {
              icon: Users,
              title: 'Team Coordination',
              description: 'Seamless coordination between designers, contractors, and vendors',
              features: ['Contractor management', 'Vendor coordination', 'Team communication', 'Quality control']
            },
            {
              icon: DollarSign,
              title: 'Budget Control',
              description: 'Comprehensive budget management and cost control throughout the project',
              features: ['Budget planning', 'Cost tracking', 'Change order management', 'Financial reporting']
            }
          ].map((service, index) => (
            <motion.div
              key={index}
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6, delay: 0.3 + index * 0.1 }}
              className="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow"
            >
              <service.icon className="w-12 h-12 text-blue-500 mb-6" />
              <h3 className="text-xl font-bold text-gray-900 mb-4">{service.title}</h3>
              <p className="text-gray-600 mb-6">{service.description}</p>
              <ul className="space-y-2">
                {service.features.map((feature, i) => (
                  <li key={i} className="flex items-center text-gray-700">
                    <CheckCircle className="w-4 h-4 text-green-500 mr-3" />
                    {feature}
                  </li>
                ))}
              </ul>
            </motion.div>
          ))}
        </motion.div>

        {/* Project Phases */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.4 }}
          className="bg-white rounded-2xl p-8 shadow-lg mb-16"
        >
          <h2 className="text-3xl font-bold text-gray-900 text-center mb-12">Complete Project Lifecycle Management</h2>
          <div className="grid md:grid-cols-2 lg:grid-cols-5 gap-6">
            {[
              {
                phase: 'Planning',
                icon: Target,
                description: 'Project scope, timeline, and resource planning',
                duration: '1-2 weeks'
              },
              {
                phase: 'Design',
                icon: Clipboard,
                description: 'Design development and approval coordination',
                duration: '2-4 weeks'
              },
              {
                phase: 'Procurement',
                icon: BarChart3,
                description: 'Material sourcing and vendor management',
                duration: '2-3 weeks'
              },
              {
                phase: 'Execution',
                icon: Users,
                description: 'Construction and installation oversight',
                duration: '4-12 weeks'
              },
              {
                phase: 'Completion',
                icon: CheckCircle,
                description: 'Final inspection and project handover',
                duration: '1 week'
              }
            ].map((phase, index) => (
              <div key={index} className="text-center">
                <div className="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                  <phase.icon className="w-8 h-8 text-blue-600" />
                </div>
                <h3 className="text-lg font-semibold text-gray-900 mb-2">{phase.phase}</h3>
                <p className="text-gray-600 text-sm mb-2">{phase.description}</p>
                <span className="text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded-full">{phase.duration}</span>
              </div>
            ))}
          </div>
        </motion.div>

        {/* Benefits & Consultation */}
        <div className="grid lg:grid-cols-2 gap-12 mb-16">
          <motion.div
            initial={{ opacity: 0, x: -20 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.8, delay: 0.5 }}
            className="bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl p-8"
          >
            <h2 className="text-2xl font-bold text-gray-900 mb-6">Why Choose Our Project Management?</h2>
            <div className="space-y-4">
              {[
                { benefit: 'Reduced project delays by 40%', icon: Clock },
                { benefit: 'Budget overruns minimized to <5%', icon: DollarSign },
                { benefit: '98% client satisfaction rate', icon: CheckCircle },
                { benefit: 'Single point of contact', icon: Users },
                { benefit: 'Real-time progress updates', icon: BarChart3 },
                { benefit: 'Quality assurance guarantee', icon: Target }
              ].map((item, index) => (
                <div key={index} className="flex items-center">
                  <item.icon className="w-5 h-5 text-blue-600 mr-3" />
                  <span className="text-gray-700">{item.benefit}</span>
                </div>
              ))}
            </div>
          </motion.div>

          <motion.div
            initial={{ opacity: 0, x: 20 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.8, delay: 0.6 }}
            className="bg-white rounded-2xl p-8 shadow-lg"
          >
            <h2 className="text-2xl font-bold text-gray-900 mb-6">Management Services</h2>
            
            {/* Consultation Notice */}
            <div className="bg-amber-50 rounded-lg p-6 mb-6 border-l-4 border-amber-500">
              <h3 className="font-semibold text-gray-900 mb-2">📋 Consultation Charges</h3>
              <p className="text-gray-700 text-sm mb-3">
                Project management consultations are billed on hourly basis for personalized project assessment and planning.
              </p>
              <p className="text-amber-700 font-medium text-sm">Consult Now for detailed package pricing</p>
            </div>

            <div className="space-y-6">
              {[
                {
                  package: 'Essential Project Coordination',
                  includes: ['Timeline management', 'Vendor coordination', 'Progress reporting', 'Basic quality control']
                },
                {
                  package: 'Complete Project Management',
                  includes: ['Complete project oversight', 'Budget management', 'Team coordination', 'Quality assurance']
                },
                {
                  package: 'Premium Management Service',
                  includes: ['White-glove service', 'Daily updates', 'Risk management', 'Concierge support']
                }
              ].map((pkg, index) => (
                <div key={index} className="border border-gray-200 rounded-lg p-4">
                  <div className="flex justify-between items-start mb-3">
                    <h3 className="font-semibold text-gray-900">{pkg.package}</h3>
                    <span className="text-blue-600 font-bold">Consult Now</span>
                  </div>
                  <ul className="space-y-1">
                    {pkg.includes.map((item, i) => (
                      <li key={i} className="text-gray-600 text-sm flex items-center">
                        <CheckCircle className="w-3 h-3 text-green-500 mr-2" />
                        {item}
                      </li>
                    ))}
                  </ul>
                </div>
              ))}
            </div>
          </motion.div>
        </div>

        {/* Contact Form */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.7 }}
          className="bg-white rounded-2xl p-8 shadow-lg"
        >
          <div className="grid lg:grid-cols-2 gap-12">
            <div>
              <h2 className="text-3xl font-bold text-gray-900 mb-6">Get Expert Project Management</h2>
              <p className="text-gray-600 mb-8">
                Ready to ensure your project runs smoothly? Contact our project management team for a 
                consultation and custom project management solution tailored to your needs.
              </p>
              
              <div className="space-y-4">
                <div className="flex items-center">
                  <Phone className="w-5 h-5 text-blue-500 mr-3" />
                  <div>
                    <p className="font-medium text-gray-900">Project Management Team</p>
                    <p className="text-gray-600">+6282233039914</p>
                  </div>
                </div>
                <div className="flex items-center">
                  <Mail className="w-5 h-5 text-blue-500 mr-3" />
                  <div>
                    <p className="font-medium text-gray-900">Project Coordination</p>
                    <p className="text-gray-600">projects@caripropshop.com</p>
                  </div>
                </div>
              </div>

              <div className="mt-8 p-4 bg-blue-50 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-2">⏰ Hourly Consultation</h3>
                <p className="text-gray-600 text-sm">
                  Our project management consultations are charged on hourly basis to provide you with 
                  dedicated expertise and thorough project assessment.
                </p>
              </div>
            </div>

            <div>
              {isSubmitted ? (
                <motion.div
                  initial={{ opacity: 0, scale: 0.9 }}
                  animate={{ opacity: 1, scale: 1 }}
                  className="text-center py-8"
                >
                  <CheckCircle className="w-16 h-16 text-green-500 mx-auto mb-4" />
                  <h3 className="text-xl font-semibold text-gray-900 mb-2">Request Sent!</h3>
                  <p className="text-gray-600">
                    Our project management team will contact you within 24 hours to discuss your project needs.
                  </p>
                </motion.div>
              ) : (
                <form onSubmit={handleSubmit} className="space-y-4">
                  <div className="grid md:grid-cols-2 gap-4">
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                      <input
                        type="text"
                        name="name"
                        value={formData.name}
                        onChange={handleChange}
                        required
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Your full name"
                      />
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                      <input
                        type="email"
                        name="email"
                        value={formData.email}
                        onChange={handleChange}
                        required
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="your@email.com"
                      />
                    </div>
                  </div>

                  <div className="grid md:grid-cols-2 gap-4">
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                      <input
                        type="tel"
                        name="phone"
                        value={formData.phone}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="+62 xxx xxx xxxx"
                      />
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Project Type *</label>
                      <select
                        name="projectType"
                        value={formData.projectType}
                        onChange={handleChange}
                        required
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                      >
                        <option value="">Select project type</option>
                        <option value="residential">Residential</option>
                        <option value="commercial">Commercial</option>
                        <option value="hospitality">Hospitality</option>
                        <option value="retail">Retail</option>
                        <option value="renovation">Renovation</option>
                        <option value="new-construction">New Construction</option>
                      </select>
                    </div>
                  </div>

                  <div className="grid md:grid-cols-2 gap-4">
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Project Size</label>
                      <select
                        name="projectSize"
                        value={formData.projectSize}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                      >
                        <option value="">Select project size</option>
                        <option value="small">Small (Under 100 sqm)</option>
                        <option value="medium">Medium (100-500 sqm)</option>
                        <option value="large">Large (500-1000 sqm)</option>
                        <option value="xl">Extra Large (Over 1000 sqm)</option>
                      </select>
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Timeline</label>
                      <select
                        name="timeline"
                        value={formData.timeline}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                      >
                        <option value="">Select timeline</option>
                        <option value="urgent">Urgent (Under 1 month)</option>
                        <option value="fast">Fast Track (1-3 months)</option>
                        <option value="standard">Standard (3-6 months)</option>
                        <option value="extended">Extended (6+ months)</option>
                      </select>
                    </div>
                  </div>

                  <div className="grid md:grid-cols-2 gap-4">
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Current Stage</label>
                      <select
                        name="currentStage"
                        value={formData.currentStage}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                      >
                        <option value="">Select current stage</option>
                        <option value="planning">Planning Phase</option>
                        <option value="design">Design Phase</option>
                        <option value="procurement">Procurement Phase</option>
                        <option value="construction">Construction Phase</option>
                        <option value="finishing">Finishing Phase</option>
                      </select>
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Main Challenges</label>
                      <select
                        name="challenges"
                        value={formData.challenges}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                      >
                        <option value="">Select main challenge</option>
                        <option value="timeline-delays">Timeline Delays</option>
                        <option value="budget-overruns">Budget Overruns</option>
                        <option value="vendor-coordination">Vendor Coordination</option>
                        <option value="quality-control">Quality Control</option>
                        <option value="communication">Communication Issues</option>
                        <option value="scope-changes">Scope Changes</option>
                        <option value="resource-management">Resource Management</option>
                      </select>
                    </div>
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-1">Project Details</label>
                    <textarea
                      name="message"
                      value={formData.message}
                      onChange={handleChange}
                      rows={3}
                      className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                      placeholder="Tell us about your project management needs, current challenges, or specific requirements..."
                    />
                  </div>

                  <button
                    type="submit"
                    className="w-full px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-purple-700 transition-all duration-300 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl"
                  >
                    <Send className="w-5 h-5" />
                    Consult Now - Request Project Management Consultation
                  </button>
                </form>
              )}
            </div>
          </div>
        </motion.div>
      </div>
        </div>
      </div>
    </div>
  );
};

export default ProjectManagement;