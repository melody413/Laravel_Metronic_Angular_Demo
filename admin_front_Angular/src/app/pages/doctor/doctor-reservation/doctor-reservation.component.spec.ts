import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DoctorReservationComponent } from './doctor-reservation.component';

describe('DoctorReservationComponent', () => {
  let component: DoctorReservationComponent;
  let fixture: ComponentFixture<DoctorReservationComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [DoctorReservationComponent]
    });
    fixture = TestBed.createComponent(DoctorReservationComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
