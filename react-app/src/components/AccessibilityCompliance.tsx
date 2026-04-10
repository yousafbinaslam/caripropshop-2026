import React from 'react';
import { motion } from 'framer-motion';
import { Accessibility, Eye, Ear, Hand, Heart, Users, CheckCircle, AlertTriangle } from 'lucide-react';

const AccessibilityCompliance: React.FC = () => {
  return (
    <div className="min-h-screen bg-gray-50 py-20">
      <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          className="bg-white rounded-2xl shadow-lg p-8"
        >
          <div className="text-center mb-12">
            <Accessibility className="w-16 h-16 text-indigo-500 mx-auto mb-4" />
            <h1 className="text-4xl font-bold text-gray-900 mb-4">Accessibility Compliance</h1>
            <p className="text-gray-600">Universal design and accessibility standards compliance</p>
          </div>

          <div className="space-y-8">
            <section>
              <div className="flex items-center mb-4">
                <Users className="w-6 h-6 text-indigo-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Universal Design Principles</h2>
              </div>
              <div className="bg-indigo-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Inclusive Design Framework</h3>
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Core Principles</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Equitable use for people with diverse abilities</li>
                      <li>• Flexibility in use and accommodation</li>
                      <li>• Simple and intuitive use patterns</li>
                      <li>• Perceptible information presentation</li>
                      <li>• Tolerance for error and safety</li>
                      <li>• Low physical effort requirements</li>
                      <li>• Size and space for approach and use</li>
                    </ul>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Design Benefits</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Enhanced usability for all users</li>
                      <li>• Improved safety and comfort</li>
                      <li>• Future-proofing for aging in place</li>
                      <li>• Increased property value and marketability</li>
                      <li>• Legal compliance and risk reduction</li>
                      <li>• Social responsibility and inclusion</li>
                      <li>• Innovation in design solutions</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <CheckCircle className="w-6 h-6 text-indigo-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Accessibility Standards Compliance</h2>
              </div>
              <div className="grid md:grid-cols-2 gap-6">
                <div className="bg-blue-50 p-6 rounded-lg border border-blue-200">
                  <h3 className="font-semibold text-gray-900 mb-3">Indonesian Standards</h3>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li className="flex items-center">
                      <CheckCircle className="w-4 h-4 text-blue-600 mr-2" />
                      SNI 03-1735-2000: Accessibility standards
                    </li>
                    <li className="flex items-center">
                      <CheckCircle className="w-4 h-4 text-blue-600 mr-2" />
                      Law No. 8/2016: Disability rights
                    </li>
                    <li className="flex items-center">
                      <CheckCircle className="w-4 h-4 text-blue-600 mr-2" />
                      Building code accessibility requirements
                    </li>
                    <li className="flex items-center">
                      <CheckCircle className="w-4 h-4 text-blue-600 mr-2" />
                      Ministry of Public Works guidelines
                    </li>
                    <li className="flex items-center">
                      <CheckCircle className="w-4 h-4 text-blue-600 mr-2" />
                      Local accessibility ordinances
                    </li>
                  </ul>
                </div>
                <div className="bg-green-50 p-6 rounded-lg border border-green-200">
                  <h3 className="font-semibold text-gray-900 mb-3">International Standards</h3>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li className="flex items-center">
                      <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                      ADA (Americans with Disabilities Act)
                    </li>
                    <li className="flex items-center">
                      <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                      ISO 21542: Accessibility in buildings
                    </li>
                    <li className="flex items-center">
                      <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                      WCAG 2.1 AA digital accessibility
                    </li>
                    <li className="flex items-center">
                      <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                      UN Convention on Rights of Persons with Disabilities
                    </li>
                    <li className="flex items-center">
                      <CheckCircle className="w-4 h-4 text-green-600 mr-2" />
                      EN 17210: European accessibility standard
                    </li>
                  </ul>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Hand className="w-6 h-6 text-indigo-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Physical Accessibility Features</h2>
              </div>
              <div className="space-y-4">
                <div className="bg-gradient-to-r from-purple-50 to-pink-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-4">Mobility & Movement</h3>
                  <div className="grid md:grid-cols-3 gap-6">
                    <div>
                      <h4 className="font-medium text-gray-900 mb-2">Entrance & Exits</h4>
                      <ul className="space-y-1 text-gray-700 text-sm">
                        <li>• Minimum 32" door width clearance</li>
                        <li>• Automatic door operators</li>
                        <li>• Level landings and thresholds</li>
                        <li>• Accessible door hardware</li>
                        <li>• Visual and tactile indicators</li>
                      </ul>
                    </div>
                    <div>
                      <h4 className="font-medium text-gray-900 mb-2">Circulation Paths</h4>
                      <ul className="space-y-1 text-gray-700 text-sm">
                        <li>• 36" minimum corridor width</li>
                        <li>• 60" turning space provisions</li>
                        <li>• Non-slip flooring materials</li>
                        <li>• Clear sight lines and navigation</li>
                        <li>• Obstacle-free pathways</li>
                      </ul>
                    </div>
                    <div>
                      <h4 className="font-medium text-gray-900 mb-2">Vertical Access</h4>
                      <ul className="space-y-1 text-gray-700 text-sm">
                        <li>• Elevator access to all levels</li>
                        <li>• Ramp specifications (1:12 slope)</li>
                        <li>• Handrail requirements</li>
                        <li>• Platform lifts where appropriate</li>
                        <li>• Stair safety and visibility</li>
                      </ul>
                    </div>
                  </div>
                </div>

                <div className="bg-gradient-to-r from-blue-50 to-cyan-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-4">Bathroom & Kitchen Accessibility</h3>
                  <div className="grid md:grid-cols-2 gap-6">
                    <div>
                      <h4 className="font-medium text-gray-900 mb-2">Accessible Bathrooms</h4>
                      <ul className="space-y-1 text-gray-700 text-sm">
                        <li>• 60" x 56" minimum clear floor space</li>
                        <li>• Roll-in shower with fold-down seat</li>
                        <li>• Grab bars at toilet and shower</li>
                        <li>• Accessible sink and mirror heights</li>
                        <li>• Lever-style faucets and controls</li>
                        <li>• Emergency call systems</li>
                      </ul>
                    </div>
                    <div>
                      <h4 className="font-medium text-gray-900 mb-2">Universal Kitchen Design</h4>
                      <ul className="space-y-1 text-gray-700 text-sm">
                        <li>• Variable height work surfaces</li>
                        <li>• Knee space under sinks and cooktops</li>
                        <li>• Pull-out shelves and drawers</li>
                        <li>• Side-by-side refrigerator configuration</li>
                        <li>• Accessible appliance controls</li>
                        <li>• Task lighting and contrast</li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Eye className="w-6 h-6 text-indigo-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Visual & Sensory Accessibility</h2>
              </div>
              <div className="grid md:grid-cols-2 gap-6">
                <div className="bg-yellow-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Visual Accessibility</h3>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li className="flex items-center">
                      <Eye className="w-4 h-4 text-yellow-600 mr-2" />
                      High contrast color schemes (3:1 minimum)
                    </li>
                    <li className="flex items-center">
                      <Eye className="w-4 h-4 text-yellow-600 mr-2" />
                      Adequate lighting levels (50+ foot-candles)
                    </li>
                    <li className="flex items-center">
                      <Eye className="w-4 h-4 text-yellow-600 mr-2" />
                      Glare reduction and light control
                    </li>
                    <li className="flex items-center">
                      <Eye className="w-4 h-4 text-yellow-600 mr-2" />
                      Tactile and Braille signage
                    </li>
                    <li className="flex items-center">
                      <Eye className="w-4 h-4 text-yellow-600 mr-2" />
                      Visual alarm systems
                    </li>
                    <li className="flex items-center">
                      <Eye className="w-4 h-4 text-yellow-600 mr-2" />
                      Large print and clear typography
                    </li>
                  </ul>
                </div>
                <div className="bg-orange-50 p-6 rounded-lg">
                  <h3 className="font-semibold text-gray-900 mb-3">Auditory Accessibility</h3>
                  <ul className="space-y-2 text-gray-700 text-sm">
                    <li className="flex items-center">
                      <Ear className="w-4 h-4 text-orange-600 mr-2" />
                      Hearing loop systems installation
                    </li>
                    <li className="flex items-center">
                      <Ear className="w-4 h-4 text-orange-600 mr-2" />
                      Sound masking and acoustic treatment
                    </li>
                    <li className="flex items-center">
                      <Ear className="w-4 h-4 text-orange-600 mr-2" />
                      Visual notification systems
                    </li>
                    <li className="flex items-center">
                      <Ear className="w-4 h-4 text-orange-600 mr-2" />
                      Vibrating alert devices
                    </li>
                    <li className="flex items-center">
                      <Ear className="w-4 h-4 text-orange-600 mr-2" />
                      TTY/TDD communication support
                    </li>
                    <li className="flex items-center">
                      <Ear className="w-4 h-4 text-orange-600 mr-2" />
                      Background noise reduction
                    </li>
                  </ul>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Heart className="w-6 h-6 text-indigo-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Cognitive & Neurological Accessibility</h2>
              </div>
              <div className="bg-gradient-to-r from-green-50 to-emerald-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Cognitive Support Design</h3>
                <div className="grid md:grid-cols-3 gap-6">
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Wayfinding & Navigation</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Clear and consistent signage systems</li>
                      <li>• Logical layout and organization</li>
                      <li>• Landmark and reference points</li>
                      <li>• Color-coded zones and areas</li>
                      <li>• Simple and intuitive pathways</li>
                    </ul>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Sensory Considerations</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Sensory-friendly lighting options</li>
                      <li>• Quiet spaces and retreat areas</li>
                      <li>• Texture and material variety</li>
                      <li>• Calming color palettes</li>
                      <li>• Reduced sensory overload</li>
                    </ul>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Safety & Security</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Clear emergency procedures</li>
                      <li>• Safe and secure environments</li>
                      <li>• Predictable and routine layouts</li>
                      <li>• Supervision and monitoring options</li>
                      <li>• Technology assistance integration</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <AlertTriangle className="w-6 h-6 text-indigo-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Accessibility Assessment & Audit</h2>
              </div>
              <div className="bg-red-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Comprehensive Accessibility Evaluation</h3>
                <div className="space-y-4">
                  {[
                    {
                      phase: 'Pre-Design Assessment',
                      scope: 'Site and user needs analysis',
                      deliverables: ['Accessibility requirements analysis', 'User consultation and feedback', 'Regulatory compliance review', 'Budget and timeline planning'],
                      color: 'red'
                    },
                    {
                      phase: 'Design Review',
                      scope: 'Accessibility integration verification',
                      deliverables: ['Design compliance checking', 'Universal design principles review', 'Accessibility feature specifications', 'Cost-benefit analysis'],
                      color: 'orange'
                    },
                    {
                      phase: 'Implementation Monitoring',
                      scope: 'Construction and installation oversight',
                      deliverables: ['Installation quality control', 'Accessibility testing and verification', 'User acceptance testing', 'Final compliance certification'],
                      color: 'green'
                    }
                  ].map((phase, index) => (
                    <div key={index} className={`bg-${phase.color}-100 p-4 rounded-lg border border-${phase.color}-200`}>
                      <div className="flex justify-between items-start mb-2">
                        <h4 className="font-medium text-gray-900">{phase.phase}</h4>
                        <span className={`text-xs text-${phase.color}-700 bg-${phase.color}-200 px-2 py-1 rounded`}>
                          {phase.scope}
                        </span>
                      </div>
                      <div className="grid md:grid-cols-2 gap-2">
                        {phase.deliverables.map((deliverable, i) => (
                          <div key={i} className="flex items-center">
                            <CheckCircle className={`w-4 h-4 text-${phase.color}-600 mr-2`} />
                            <span className="text-gray-700 text-sm">{deliverable}</span>
                          </div>
                        ))}
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <Users className="w-6 h-6 text-indigo-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Accessibility Consulting Services</h2>
              </div>
              <div className="bg-indigo-50 p-6 rounded-lg">
                <h3 className="font-semibold text-gray-900 mb-4">Specialized Accessibility Support</h3>
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Consultation Services</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Accessibility needs assessment</li>
                      <li>• Universal design planning</li>
                      <li>• Regulatory compliance guidance</li>
                      <li>• Retrofit and modification planning</li>
                      <li>• Technology integration consulting</li>
                      <li>• Training and education programs</li>
                    </ul>
                  </div>
                  <div>
                    <h4 className="font-medium text-gray-900 mb-2">Specialized Expertise</h4>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Certified accessibility specialists</li>
                      <li>• Occupational therapy consultation</li>
                      <li>• Assistive technology integration</li>
                      <li>• Aging-in-place design</li>
                      <li>• Sensory-friendly environments</li>
                      <li>• Inclusive design innovation</li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section>
              <div className="flex items-center mb-4">
                <CheckCircle className="w-6 h-6 text-indigo-500 mr-3" />
                <h2 className="text-2xl font-semibold text-gray-900">Accessibility Certifications & Training</h2>
              </div>
              <div className="bg-purple-50 p-6 rounded-lg">
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Team Certifications</h3>
                    <div className="space-y-3">
                      <div className="bg-white p-3 rounded border">
                        <h4 className="font-medium text-gray-900">Certified Aging-in-Place Specialist</h4>
                        <p className="text-gray-600 text-sm">Accessibility Design Specialist</p>
                      </div>
                      <div className="bg-white p-3 rounded border">
                        <h4 className="font-medium text-gray-900">Universal Design Certified Professional</h4>
                        <p className="text-gray-600 text-sm">Inclusive Design Specialist</p>
                      </div>
                      <div className="bg-white p-3 rounded border">
                        <h4 className="font-medium text-gray-900">ADA Compliance Specialist</h4>
                        <p className="text-gray-600 text-sm">Team Certification - Regulatory Compliance</p>
                      </div>
                    </div>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-3">Ongoing Education</h3>
                    <ul className="space-y-2 text-gray-700 text-sm">
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-purple-600 mr-2" />
                        Annual accessibility training updates
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-purple-600 mr-2" />
                        Disability awareness workshops
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-purple-600 mr-2" />
                        Assistive technology seminars
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-purple-600 mr-2" />
                        Universal design conferences
                      </li>
                      <li className="flex items-center">
                        <CheckCircle className="w-4 h-4 text-purple-600 mr-2" />
                        Regulatory update training
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </section>

            <section className="border-t pt-8">
              <h2 className="text-2xl font-semibold text-gray-900 mb-4">Accessibility Compliance Contact</h2>
              <div className="bg-indigo-50 p-6 rounded-lg">
                <p className="text-gray-700 mb-4">
                  For accessibility consultation, compliance questions, or universal design services.
                </p>
                <div className="grid md:grid-cols-2 gap-6">
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-2">Accessibility Specialist</h3>
                    <div className="space-y-1 text-gray-700 text-sm">
                      <p><strong>Name:</strong> Cari Prop Shop</p>
                      <p><strong>Email:</strong> accessibility@caripropshop.com</p>
                      <p><strong>Phone:</strong> Available upon request</p>
                      <p><strong>Certification:</strong> CAPS, Universal Design</p>
                    </div>
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-2">Services Available</h3>
                    <ul className="space-y-1 text-gray-700 text-sm">
                      <li>• Accessibility assessments and audits</li>
                      <li>• Universal design consultation</li>
                      <li>• Compliance verification services</li>
                      <li>• Assistive technology integration</li>
                    </ul>
                  </div>
                </div>
                <div className="mt-4 p-4 bg-indigo-100 rounded-lg">
                  <p className="text-indigo-800 text-sm">
                    <strong>Commitment:</strong> We are dedicated to creating inclusive environments that welcome 
                    and accommodate people of all abilities, ensuring equal access and dignity for everyone.
                  </p>
                </div>
              </div>
            </section>
          </div>
        </motion.div>
      </div>
    </div>
  );
};

export default AccessibilityCompliance;