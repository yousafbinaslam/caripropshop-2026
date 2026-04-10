import React, { useState } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { Lightbulb, MessageCircle, Clock, Video, CheckCircle, Send, Phone, Mail, ArrowLeft, Star, Award, Users, Target } from 'lucide-react';
import { sendAutomatedResponse } from '../utils/emailService';
import Header from './Header';

const DesignConsultation: React.FC = () => {
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    phone: '',
    consultationType: '',
    projectType: '',
    spaceType: '',
    consultationMode: '',
    urgency: '',
    currentStage: '',
    specificNeeds: '',
    availableTime: '',
    location: '',
    experience: '',
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
      formType: 'Design Consultation Request',
      consultationType: formData.consultationType,
      projectType: formData.projectType,
      spaceType: formData.spaceType,
      consultationMode: formData.consultationMode,
      urgency: formData.urgency,
      currentStage: formData.currentStage,
      priorities: formData.priorities,
      specificNeeds: formData.specificNeeds,
      availableTime: formData.availableTime,
      experience: formData.experience,
      message: formData.message
    });
    
    setIsSubmitted(true);
    setTimeout(() => setIsSubmitted(false), 3000);
    setFormData({
      name: '',
      email: '',
      phone: '',
      consultationType: '',
      projectType: '',
      spaceType: '',
      consultationMode: '',
      urgency: '',
      currentStage: '',
      specificNeeds: '',
      availableTime: '',
      location: '',
      experience: '',
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
            <div className="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center">
              <Lightbulb className="w-10 h-10 text-white" />
            </div>
          </div>
          <h1 className="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
            Design Consultation Services
          </h1>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Get expert design advice and guidance from our experienced interior designers. Whether you need 
            a quick consultation or comprehensive design direction, we're here to help bring your vision to life.
          </p>
        </motion.div>

        {/* Consultation Types */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.2 }}
          className="grid md:grid-cols-3 gap-8 mb-16"
        >
          {[
            {
              icon: MessageCircle,
              title: 'Quick Consultation',
              description: 'Get immediate design advice for specific questions or challenges',
              features: ['30-60 minute session', 'Specific problem solving', 'Design direction', 'Material advice'],
              pricing: 'Hourly Basis'
            },
            {
              icon: Video,
              title: 'Virtual Design Session',
              description: 'Comprehensive online consultation with detailed design guidance',
              features: ['90-120 minute session', 'Space analysis', 'Design concepts', 'Shopping list'],
              pricing: 'Hourly Basis'
            },
            {
              icon: Users,
              title: 'In-Person Consultation',
              description: 'On-site visit with detailed space assessment and design planning',
              features: ['2-3 hour session', 'Site measurement', 'Detailed analysis', 'Design proposal'],
              pricing: 'Hourly Basis'
            }
          ].map((service, index) => (
            <motion.div
              key={index}
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6, delay: 0.3 + index * 0.1 }}
              className="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow"
            >
              <service.icon className="w-12 h-12 text-purple-500 mb-6" />
              <h3 className="text-xl font-bold text-gray-900 mb-4">{service.title}</h3>
              <p className="text-gray-600 mb-6">{service.description}</p>
              <ul className="space-y-2 mb-6">
                {service.features.map((feature, i) => (
                  <li key={i} className="flex items-center text-gray-700">
                    <CheckCircle className="w-4 h-4 text-purple-500 mr-3" />
                    {feature}
                  </li>
                ))}
              </ul>
              <div className="text-lg font-semibold text-purple-600">{service.pricing}</div>
            </motion.div>
          ))}
        </motion.div>

        {/* Consultation Notice */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.4 }}
          className="bg-gradient-to-r from-amber-50 to-orange-50 rounded-2xl p-8 border border-amber-200 mb-16"
        >
          <div className="text-center">
            <h3 className="text-2xl font-bold text-gray-900 mb-4">📋 Important: Consultation Charges Are Hourly Basis</h3>
            <p className="text-gray-700 text-lg mb-4">
              All our design consultations are billed on hourly basis to ensure you receive personalized, 
              focused attention and maximum value for the time invested in your project.
            </p>
            <div className="bg-white rounded-lg p-6 inline-block">
              <p className="text-amber-700 font-semibold">⏰ Hourly consultation ensures dedicated expertise and thorough project guidance</p>
            </div>
          </div>
        </motion.div>

        {/* What to Expect */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.4 }}
          className="bg-white rounded-2xl p-8 shadow-lg mb-16"
        >
          <h2 className="text-3xl font-bold text-gray-900 text-center mb-12">What to Expect from Your Consultation</h2>
          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            {[
              {
                step: '1',
                title: 'Initial Assessment',
                description: 'We discuss your needs, style preferences, and project goals'
              },
              {
                step: '2',
                title: 'Space Analysis',
                description: 'Detailed evaluation of your space, layout, and potential'
              },
              {
                step: '3',
                title: 'Design Direction',
                description: 'Professional recommendations for colors, materials, and layout'
              },
              {
                step: '4',
                title: 'Action Plan',
                description: 'Clear next steps and implementation guidance'
              }
            ].map((step, index) => (
              <div key={index} className="text-center">
                <div className="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                  <span className="text-2xl font-bold text-purple-600">{step.step}</span>
                </div>
                <h3 className="text-lg font-semibold text-gray-900 mb-2">{step.title}</h3>
                <p className="text-gray-600 text-sm">{step.description}</p>
              </div>
            ))}
          </div>
        </motion.div>

        {/* Benefits & Process */}
        <div className="grid lg:grid-cols-2 gap-12 mb-16">
          <motion.div
            initial={{ opacity: 0, x: -20 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.8, delay: 0.5 }}
            className="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-8"
          >
            <h2 className="text-2xl font-bold text-gray-900 mb-6">Why Choose Our Consultation?</h2>
            <div className="space-y-4">
              {[
                { benefit: 'Expert Design Guidance', desc: 'Professional advice from certified interior designers' },
                { benefit: 'Cost-Effective Solutions', desc: 'Avoid expensive mistakes with expert recommendations' },
                { benefit: 'Personalized Approach', desc: 'Tailored advice based on your specific needs and style' },
                { benefit: 'Flexible Scheduling', desc: 'Available for in-person, virtual, or phone consultations' },
                { benefit: 'Immediate Results', desc: 'Walk away with actionable design direction' },
                { benefit: 'Follow-up Support', desc: 'Ongoing guidance as you implement recommendations' }
              ].map((item, index) => (
                <div key={index} className="flex items-start">
                  <CheckCircle className="w-5 h-5 text-purple-500 mr-3 mt-1" />
                  <div>
                    <h3 className="font-semibold text-gray-900">{item.benefit}</h3>
                    <p className="text-gray-600 text-sm">{item.desc}</p>
                  </div>
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
            <h2 className="text-2xl font-bold text-gray-900 mb-6">Consultation Services</h2>
            <div className="space-y-6">
              {[
                {
                  package: 'Quick Design Direction',
                  includes: ['Problem assessment', 'Design recommendations', 'Material suggestions', 'Next steps plan']
                },
                {
                  package: 'Comprehensive Design Review',
                  includes: ['Full space analysis', 'Design concepts', 'Shopping guidance', 'Implementation timeline']
                },
                {
                  package: 'Premium Design Consultation',
                  includes: ['On-site visit', 'Detailed measurements', 'Design proposal', 'Follow-up support']
                }
              ].map((pkg, index) => (
                <div key={index} className="border border-gray-200 rounded-lg p-4">
                  <div className="flex justify-between items-start mb-3">
                    <h3 className="font-semibold text-gray-900">{pkg.package}</h3>
                    <span className="text-purple-600 font-bold">Consult Now</span>
                  </div>
                  <ul className="space-y-1">
                    {pkg.includes.map((item, i) => (
                      <li key={i} className="text-gray-600 text-sm flex items-center">
                        <CheckCircle className="w-3 h-3 text-purple-500 mr-2" />
                        {item}
                      </li>
                    ))}
                  </ul>
                </div>
              ))}
            </div>
          </motion.div>
        </div>

        {/* Testimonials */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.7 }}
          className="bg-white rounded-2xl p-8 shadow-lg mb-16"
        >
          <h2 className="text-3xl font-bold text-gray-900 text-center mb-12">Client Success Stories</h2>
          <div className="grid md:grid-cols-3 gap-8">
            {[
              {
                name: 'Sarah M.',
                project: 'Living Room Redesign',
                quote: 'The consultation saved me thousands! The designer helped me avoid costly mistakes and gave me a clear direction.',
                rating: 5
              },
              {
                name: 'David L.',
                project: 'Office Space Planning',
                quote: 'Virtual consultation was perfect for my busy schedule. Got exactly the guidance I needed to move forward.',
                rating: 5
              },
              {
                name: 'Maria K.',
                project: 'Kitchen Layout',
                quote: 'The in-person consultation was incredibly detailed. Every recommendation was spot-on and practical.',
                rating: 5
              }
            ].map((testimonial, index) => (
              <div key={index} className="text-center">
                <div className="flex justify-center mb-4">
                  {[...Array(testimonial.rating)].map((_, i) => (
                    <Star key={i} className="w-5 h-5 text-yellow-400 fill-current" />
                  ))}
                </div>
                <p className="text-gray-700 italic mb-4">"{testimonial.quote}"</p>
                <div>
                  <p className="font-semibold text-gray-900">{testimonial.name}</p>
                  <p className="text-sm text-gray-600">{testimonial.project}</p>
                </div>
              </div>
            ))}
          </div>
        </motion.div>

        {/* Contact Form */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.8 }}
          className="bg-white rounded-2xl p-8 shadow-lg"
        >
          <div className="grid lg:grid-cols-2 gap-12">
            <div>
              <h2 className="text-3xl font-bold text-gray-900 mb-6">Book Your Design Consultation</h2>
              <p className="text-gray-600 mb-8">
                Ready to get expert design guidance? Schedule your consultation today and take the first 
                step towards creating your dream space.
              </p>
              
              <div className="space-y-4 mb-8">
                <div className="flex items-center">
                  <Phone className="w-5 h-5 text-purple-500 mr-3" />
                  <div>
                    <p className="font-medium text-gray-900">Consultation Booking</p>
                    <p className="text-gray-600">+6282233541409</p>
                  </div>
                </div>
                <div className="flex items-center">
                  <Mail className="w-5 h-5 text-purple-500 mr-3" />
                  <div>
                    <p className="font-medium text-gray-900">Design Consultants</p>
                    <p className="text-gray-600">consult@caripropshop.com</p>
                  </div>
                </div>
              </div>

              <div className="grid grid-cols-3 gap-4 text-center">
                <div className="p-4 bg-purple-50 rounded-lg">
                  <Clock className="w-6 h-6 text-purple-500 mx-auto mb-2" />
                  <p className="text-sm font-medium text-gray-900">24hr</p>
                  <p className="text-xs text-gray-600">Response Time</p>
                </div>
                <div className="p-4 bg-purple-50 rounded-lg">
                  <Award className="w-6 h-6 text-purple-500 mx-auto mb-2" />
                  <p className="text-sm font-medium text-gray-900">500+</p>
                  <p className="text-xs text-gray-600">Consultations</p>
                </div>
                <div className="p-4 bg-purple-50 rounded-lg">
                  <Target className="w-6 h-6 text-purple-500 mx-auto mb-2" />
                  <p className="text-sm font-medium text-gray-900">98%</p>
                  <p className="text-xs text-gray-600">Satisfaction</p>
                </div>
              </div>
            </div>

            <div>
              {isSubmitted ? (
                <motion.div
                  initial={{ opacity: 0, scale: 0.9 }}
                  animate={{ opacity: 1, scale: 1 }}
                  className="text-center py-8"
                >
                  <CheckCircle className="w-16 h-16 text-purple-500 mx-auto mb-4" />
                  <h3 className="text-xl font-semibold text-gray-900 mb-2">Request Sent!</h3>
                  <p className="text-gray-600">
                    Our design consultation team will contact you within 24 hours to schedule your session.
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
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
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
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
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
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        placeholder="+62 xxx xxx xxxx"
                      />
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Location</label>
                      <input
                        type="text"
                        name="location"
                        value={formData.location}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        placeholder="City, Indonesia"
                      />
                    </div>
                  </div>

                  <div className="grid md:grid-cols-2 gap-4">
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Consultation Type *</label>
                      <select
                        name="consultationType"
                        value={formData.consultationType}
                        onChange={handleChange}
                        required
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                      >
                        <option value="">Select consultation type</option>
                        <option value="quick-consultation">Quick Consultation (30-60 min)</option>
                        <option value="virtual-session">Virtual Design Session (90-120 min)</option>
                        <option value="in-person">In-Person Consultation (2-3 hours)</option>
                        <option value="follow-up">Follow-up Session</option>
                      </select>
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Consultation Mode</label>
                      <select
                        name="consultationMode"
                        value={formData.consultationMode}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                      >
                        <option value="">Select mode</option>
                        <option value="video-call">Video Call</option>
                        <option value="phone-call">Phone Call</option>
                        <option value="in-person">In-Person Visit</option>
                        <option value="email">Email Consultation</option>
                      </select>
                    </div>
                  </div>

                  <div className="grid md:grid-cols-2 gap-4">
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Project Type</label>
                      <select
                        name="projectType"
                        value={formData.projectType}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                      >
                        <option value="">Select project type</option>
                        <option value="residential">Residential</option>
                        <option value="commercial">Commercial</option>
                        <option value="hospitality">Hospitality</option>
                        <option value="retail">Retail</option>
                        <option value="mixed-use">Mixed Use</option>
                      </select>
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Space Type</label>
                      <select
                        name="spaceType"
                        value={formData.spaceType}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                      >
                        <option value="">Select space type</option>
                        <option value="living-room">Living Room</option>
                        <option value="bedroom">Bedroom</option>
                        <option value="kitchen">Kitchen</option>
                        <option value="bathroom">Bathroom</option>
                        <option value="office">Office</option>
                        <option value="entire-home">Entire Home</option>
                        <option value="entire-office">Entire Office</option>
                        <option value="multiple-rooms">Multiple Rooms</option>
                      </select>
                    </div>
                  </div>

                  <div className="grid md:grid-cols-2 gap-4">
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Urgency</label>
                      <select
                        name="urgency"
                        value={formData.urgency}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                      >
                        <option value="">Select urgency</option>
                        <option value="urgent">Urgent (This week)</option>
                        <option value="soon">Soon (Next 2 weeks)</option>
                        <option value="flexible">Flexible (Next month)</option>
                        <option value="planning">Planning (Future)</option>
                      </select>
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Current Stage</label>
                      <select
                        name="currentStage"
                        value={formData.currentStage}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                      >
                        <option value="">Select current stage</option>
                        <option value="just-starting">Just Starting</option>
                        <option value="researching">Researching Ideas</option>
                        <option value="planning">Planning Phase</option>
                        <option value="ready-to-implement">Ready to Implement</option>
                        <option value="stuck">Stuck/Need Direction</option>
                        <option value="second-opinion">Need Second Opinion</option>
                      </select>
                    </div>
                  </div>

                  <div className="grid md:grid-cols-2 gap-4">
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Available Time</label>
                      <select
                        name="availableTime"
                        value={formData.availableTime}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                      >
                        <option value="">Select preferred time</option>
                        <option value="weekday-morning">Weekday Morning</option>
                        <option value="weekday-afternoon">Weekday Afternoon</option>
                        <option value="weekday-evening">Weekday Evening</option>
                        <option value="weekend-morning">Weekend Morning</option>
                        <option value="weekend-afternoon">Weekend Afternoon</option>
                        <option value="flexible">Flexible</option>
                      </select>
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Specific Needs</label>
                      <select
                        name="specificNeeds"
                        value={formData.specificNeeds}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                      >
                        <option value="">Select main need</option>
                        <option value="color-scheme">Color Scheme Help</option>
                        <option value="layout-planning">Layout Planning</option>
                        <option value="furniture-selection">Furniture Selection</option>
                        <option value="lighting-design">Lighting Design</option>
                        <option value="storage-solutions">Storage Solutions</option>
                        <option value="style-direction">Style Direction</option>
                        <option value="budget-planning">Budget Planning</option>
                        <option value="problem-solving">Problem Solving</option>
                      </select>
                    </div>
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-1">Project Details & Questions</label>
                    <textarea
                      name="message"
                      value={formData.message}
                      onChange={handleChange}
                      rows={4}
                      className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none"
                      placeholder="Tell us about your space, challenges, goals, or specific questions you'd like to discuss during the consultation..."
                    />
                  </div>

                  <button
                    type="submit"
                    className="w-full px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-600 text-white font-semibold rounded-lg hover:from-purple-600 hover:to-pink-700 transition-all duration-300 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl"
                  >
                    <Send className="w-5 h-5" />
                    Consult Now - Request Design Consultation
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

export default DesignConsultation;