import { ComponentFixture, TestBed } from '@angular/core/testing';

import { LabServiceListComponent } from './lab-service-list.component';

describe('LabServiceListComponent', () => {
  let component: LabServiceListComponent;
  let fixture: ComponentFixture<LabServiceListComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [LabServiceListComponent]
    });
    fixture = TestBed.createComponent(LabServiceListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
